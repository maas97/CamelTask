<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Cache, Validator, DB};
use App\Models\{User, Subscription};
use Illuminate\Support\Str;


class RegistrationController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/register/step1",
     *     summary="Initiate Registration - Step 1",
     *     description="Validates the user registration details (name, email, phone) and returns an encrypted UUID for further registration steps.",
     *     operationId="registrationStep1",
     *     tags={"Registration"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User details for registration",
     *         @OA\JsonContent(
     *             required={"name", "email", "phone"},
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Mohamed Ashraf",
     *                 description="User's name. Only alphabetical letters and spaces are allowed (whitespace-only names are not permitted)."
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 example="john.doe@example.com",
     *                 description="User's unique email address."
     *             ),
     *             @OA\Property(
     *                 property="phone",
     *                 type="string",
     *                 example="+1234567890",
     *                 description="User's phone number. Must pass custom phone validation."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Registration step 1 successful. Returns an encrypted UUID.",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="encryptedUuid",
     *                 type="string",
     *                 example="eyJpdiI6IjBhNzhjMzBiNDM3Y2Y0N2YwZTM5ZjYxIiwidmFsdWUiOiJ1QWZyK1p1Y0ZxUldGc2hKbmdYcDl2UT09IiwibWFjIjoiYjZhNTNlNzM3MjI4Y2U0NGJhNzliYzEwNTdhNjhlMmFkM2U1NTkzMmI0MzllNzBmMzFlNDdlYTMyYjczOWI0NSJ9",
     *                 description="Encrypted UUID for the current registration session."
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error. The input did not pass validation.",
     *         @OA\JsonContent(
     *             type="object",
     *             additionalProperties={
     *                 "type": "array",
     *                 "items": { "type": "string" }
     *             },
     *             example={
     *                 "email": {"The email has already been taken."},
     *                 "name": {"The name format is invalid."}
     *             }
     *         )
     *     )
     * )
     */

    public function step1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s]*\pL[\pL\s]*$/u', // regex for any alphabetical letters in uft-8 with white spaces, but not whitespaces only
            'email' => 'required|email:rfc,dns|unique:users,email',
            'phone' => 'required|regex:/^\+[1-9]\d{1,14}$/',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $uuid = (string) Str::uuid();
        Cache::put($uuid, ['step1' => $validator->validated()], now()->addMinutes(30));

        return response()->json(['uuid' => $uuid]);
    }

    public function step2(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
            'plan' => 'required|in:arcade,advanced,pro',
            'billing_cycle' => 'required|in:monthly,yearly'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Cache::get($validator->validated()['uuid']);

        if (!$data || !isset($data['step1'])) {
            return response()->json(['error' => 'Invalid session'], 400);
        }

        $data['step2'] = $validator->validated();
        Cache::put($validator->validated()['uuid'], $data, now()->addMinutes(30));

        return response()->json(['message' => 'Plan saved']);
    }

    public function step3(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
            'addons' => 'array',
            'addons.*' => 'in:online_service,larger_storage,customizable_profile'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Cache::get($validator->validated()['uuid']);
        if (!$data || !isset($data['step2'])) {
            return response()->json(['error' => 'Invalid session'], 400);
        }

        $data['step3'] = $validator->validated()['addons'] ?? [];
        Cache::put($validator->validated()['uuid'], $data, now()->addMinutes(30));

        return response()->json(['message' => 'Addons saved']);
    }

    public function complete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = Cache::get($validator->validated()['uuid']);


        if (!$data || !isset($data['step1'], $data['step2'], $data['step3'])) {
            return response()->json(['error' => 'Invalid session'], 400);
        }

        DB::beginTransaction();
        try {
            $user = User::create($data['step1']);

            $subscriptionData = [
                'user_id' => $user->id,
                'plan_name' => $data['step2']['plan'],
                'billing_cycle' => $data['step2']['billing_cycle'],
                'price' => $this->calculatePrice(
                    $data['step2']['plan'],
                    $data['step2']['billing_cycle']
                    )
                ];

            $subs = Subscription::create($subscriptionData);

            $addons = $this->mapAddons($data['step3'], $data['step2']['billing_cycle']);

            $user->addons()->createMany($addons);

            DB::commit();
            Cache::forget($validator->validated()['uuid']);

            return response()->json([
                'message' => 'Registration complete',
                'user' => $user,
                'subscription' => $subscriptionData,
                'addons' => $addons
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Registration failed'], 500);
        }
    }

    private function calculatePrice($plan, $billingCycle)
    {
        $prices = [
            'monthly' => [
                'arcade' => 9,
                'advanced' => 12,
                'pro' => 15
            ],
            'yearly' => [
                'arcade' => 90,
                'advanced' => 120,
                'pro' => 150
            ]
        ];

        return $prices[$billingCycle][$plan];
    }

    private function mapAddons($addons, $billingCycle)
    {
        $prices = [
            'monthly' => [
                'online_service' => 1,
                'larger_storage' => 2,
                'customizable_profile' => 2
            ],
            'yearly' => [
                'online_service' => 10,
                'larger_storage' => 20,
                'customizable_profile' => 20
            ]
        ];

        return collect($addons)->map(function ($addon) use ($prices, $billingCycle) {
            return [
                'name' => $addon,
                'price' => $prices[$billingCycle][$addon]
            ];
        })->toArray();
    }
}
