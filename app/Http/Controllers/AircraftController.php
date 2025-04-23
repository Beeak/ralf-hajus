<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AircraftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $aircraft = Aircraft::all();
        return view('aircraft.index', compact('aircraft'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('aircraft.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'type' => 'required|string',
            'aircraft_type' => 'required|string',
        ]);

        Aircraft::create($validated);

        return redirect()->route('aircraft.index')
            ->with('success', 'Aircraft created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aircraft $aircraft): View
    {
        return view('aircraft.show', compact('aircraft'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aircraft $aircraft): View
    {
        return view('aircraft.edit', compact('aircraft'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aircraft $aircraft): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'type' => 'required|string',
            'aircraft_type' => 'required|string',
        ]);

        $aircraft->update($validated);

        return redirect()->route('aircraft.index')
            ->with('success', 'Aircraft updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aircraft $aircraft): RedirectResponse
    {
        $aircraft->delete();

        return redirect()->route('aircraft.index')
            ->with('success', 'Aircraft deleted successfully');
    }
}