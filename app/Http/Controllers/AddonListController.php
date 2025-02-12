<?php

namespace App\Http\Controllers;

use App\Models\AddonList;
use Illuminate\Http\Request;

class AddonListController extends Controller
{
    public function index()
    {
        $addons = AddonList::all();
        return response()->json($addons);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'billing_cycle' => 'required|in:monthly,yearly',
            'price'         => 'required|integer',
        ]);

        $addon = AddonList::create($validated);

        return response()->json($addon, 201);
    }

    public function update(Request $request, $id)
    {
        $addon = AddonList::findOrFail($id);

        $validated = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'billing_cycle' => 'sometimes|required|in:monthly,yearly',
            'price'         => 'sometimes|required|integer',
        ]);

        $addon->update($validated);

        return response()->json($addon);
    }

    public function destroy($id)
    {
        $addon = AddonList::findOrFail($id);
        $addon->delete();

        return response()->json(null, 204);
    }
}
