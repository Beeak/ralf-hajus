<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class AircraftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $aircraft = Cache::remember('aircraft.all', 600, function () {
            return Aircraft::all();
        });
        
        return response()->json(['data' => $aircraft]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|string',
            'aircraft_type' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();


            
            $image->storeAs('public/images/api', $imageName);
            
            $validated['image'] = $imageName;
        }

        $aircraft = Aircraft::create($validated);
        
        Cache::forget('aircraft.all');

        return response()->json([
            'message' => 'Aircraft created successfully',
            'data' => $aircraft
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Aircraft $aircraft): JsonResponse
    {
        $cachedAircraft = Cache::remember('aircraft.' . $aircraft->id, 600, function () use ($aircraft) {
            return $aircraft;
        });
        
        return response()->json(['data' => $cachedAircraft]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aircraft $aircraft): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'sometimes|required|string',
            'aircraft_type' => 'sometimes|required|string',
        ]);
        dd($request->hasFile('image'));
        if ($request->hasFile('image')) {
            if ($aircraft->image) {
                Storage::delete($aircraft->image);
            }
            
            $image = $request->file('image')->store('images/api');
            
            $validated['image'] = $image;
        }

        $aircraft->update($validated);
        
        Cache::forget('aircraft.' . $aircraft->id);
        Cache::forget('aircraft.all');

        return response()->json([
            'message' => 'Aircraft updated successfully',
            'data' => $aircraft
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aircraft $aircraft): JsonResponse
    {
        if ($aircraft->image) {
            Storage::delete('public/images/api/' . $aircraft->image);
        }
        
        Cache::forget('aircraft.' . $aircraft->id);
        Cache::forget('aircraft.all');
        
        $aircraft->delete();

        return response()->json([
            'message' => 'Aircraft deleted successfully'
        ]);
    }
}
