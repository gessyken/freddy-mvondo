<?php

namespace App\Http\Controllers;

use App\Models\Urbanisme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UrbanismeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $urbanismeRequests = Urbanisme::where('user_id', Auth::id())
                                     ->latest()
                                     ->paginate(10);
        return view('urbanisme.index', compact('urbanismeRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('urbanisme.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('urbanisme_photos', 'public');
        }

        Urbanisme::create([
            'user_id' => Auth::id(),
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'photo_path' => $photoPath,
            'latitude' => $validatedData['latitude'],
            'longitude' => $validatedData['longitude'],
        ]);

        return redirect()->route('urbanisme.index')->with('success', 'Votre demande d\'urbanisme a été soumise avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Urbanisme $urbanisme)
    {
        // Basic authorization: ensure the user owns the request
        if (Auth::id() !== $urbanisme->user_id) {
            abort(403, 'Accès non autorisé.');
        }

        return view('urbanisme.show', ['urbanismeRequest' => $urbanisme]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Urbanisme $urbanisme)
    {
        if (Auth::id() !== $urbanisme->user_id) {
            abort(403, 'Accès non autorisé.');
        }

        return view('urbanisme.edit', ['urbanismeRequest' => $urbanisme]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Urbanisme $urbanisme)
    {
        if (Auth::id() !== $urbanisme->user_id) {
            abort(403, 'Accès non autorisé.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $dataToUpdate = $request->only(['title', 'description', 'latitude', 'longitude']);

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($urbanisme->photo_path) {
                Storage::disk('public')->delete($urbanisme->photo_path);
            }
            $dataToUpdate['photo_path'] = $request->file('photo')->store('urbanisme_photos', 'public');
        }

        $urbanisme->update($dataToUpdate);

        return redirect()->route('urbanisme.show', $urbanisme)->with('success', 'Votre demande a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Urbanisme $urbanisme)
    {
        if (Auth::id() !== $urbanisme->user_id) {
            abort(403, 'Accès non autorisé.');
        }

        // Delete the photo if it exists
        if ($urbanisme->photo_path) {
            Storage::disk('public')->delete($urbanisme->photo_path);
        }

        $urbanisme->delete();

        return redirect()->route('urbanisme.index')->with('success', 'La demande a été supprimée avec succès.');
    }
}