<?php

namespace App\Http\Controllers;

use App\Models\Don;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Don::where('user_id', Auth::id());

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('titre', 'like', "%$search%");
        }

        $dons = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('dons.index', compact('dons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'categorie' => 'required|string',
            'localisation' => 'nullable|string',
            'statut' => 'required|in:disponible,réservé,donné',
            'image' => 'nullable|image|max:2048', // max 2MB, seulement image
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('dons_images', 'public');
            $validated['image'] = $path;
        }

        $validated['user_id'] = Auth::id();

        Don::create($validated);

        return redirect()->route('dons.index')->with('success', 'Don créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
   /*  public function show(Don $don)
    {
        //
    }  */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Don $don)
    {
        //$this->authorize('update', $don);
        return view('dons.edit', compact('don'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Don $don)
    {
        //$this->authorize('update', $don);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'categorie' => 'required|string',
            'localisation' => 'nullable|string',
            'statut' => 'required|in:disponible,réservé,donné',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Optionnel: supprimer ancienne image si existe
            if ($don->image) {
                \Storage::disk('public')->delete($don->image);
            }

            $path = $request->file('image')->store('dons_images', 'public');
            $validated['image'] = $path;
        }

        $don->update($validated);

        return redirect()->route('dons.index')->with('success', 'Don mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Don $don)
    {
        //$this->authorize('delete', $don);
        $don->delete();

        return redirect()->route('dons.index')->with('success', 'Don supprimé.');
    }
}
