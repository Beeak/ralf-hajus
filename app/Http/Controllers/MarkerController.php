<?php

namespace App\Http\Controllers;

use App\Models\Marker;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    public function index()
    {
        $markers = Marker::all();
        return view('markers.index', compact('markers'));
    }

    public function create()
    {
        return view('markers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $marker = Marker::create($validated);

        return response()->json(['success' => true, 'marker' => $marker]);
    }

    public function show(Marker $marker)
    {
        return view('markers.show', compact('marker'));
    }

    public function edit(Marker $marker)
    {
        return view('markers.edit', compact('marker'));
    }

    public function update(Request $request, Marker $marker)
    {
        $request->validate([
            'name' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
        ]);

        $marker->update($request->all());

        return redirect()->route('markers.index')
            ->with('success', 'Marker updated successfully');
    }

    public function destroy(Marker $marker)
    {
        $marker->delete();

        return redirect()->route('markers.index')
            ->with('success', 'Marker deleted successfully');
    }
}
