<?php

namespace App\Http\Controllers;

use App\Models\Don;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        $categorie = $request->input('categorie');

        $query = Don::query()->where('statut', 'disponible');

        if ($categorie) {
            $query->where('categorie', $categorie);
        }

        $dons = $query->latest()->paginate(8);

        $categories = Don::select('categorie')->distinct()->pluck('categorie');

        return view('welcome', compact('dons', 'categories', 'categorie'));
    }

    
    public function show(Don $don)
    {
        $don->load('user'); // pour éviter les appels null

        return view('show', compact('don')); // pas dans un sous-dossier
    }
}
