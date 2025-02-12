<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionList;
use Illuminate\Http\Request;

class SubscriptionListController extends Controller
{
    public function index()
    {
        $subscriptions = SubscriptionList::all();
        return response()->json($subscriptions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_name'     => 'required|string|max:255',
            'billing_cycle' => 'required|in:monthly,yearly',
            'price'         => 'required|integer',
        ]);

        $subscription = SubscriptionList::create($validated);

        return response()->json($subscription, 201);
    }

    public function update(Request $request, $id)
    {
        $subscription = SubscriptionList::findOrFail($id);

        $validated = $request->validate([
            'plan_name'     => 'sometimes|required|string|max:255',
            'billing_cycle' => 'sometimes|required|in:monthly,yearly',
            'price'         => 'sometimes|required|integer',
        ]);

        $subscription->update($validated);

        return response()->json($subscription);
    }

    public function destroy($id)
    {
        $subscription = SubscriptionList::findOrFail($id);
        $subscription->delete();

        return response()->json(null, 204);
    }
}
