<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Afficher la page d'accueil avec les actualités
     */
    public function index()
    {
        // Récupérer les actualités publiées, triées par date de publication, limitées à 3
        $actualites = News::with('images')
            ->where('is_published', true)
            ->where('published_date', '<=', now())
            ->orderBy('published_date', 'desc')
            ->limit(3)
            ->get();

        return view('accueil', compact('actualites'));
    }

    /**
     * Afficher toutes les actualités (page actualités)
     */
    public function actualites()
    {
        $actualites = News::with('images')
            ->where('is_published', true)
            ->where('published_date', '<=', now())
            ->orderBy('published_date', 'desc')
            ->paginate(9);

        return view('actualites', compact('actualites'));
    }

    /**
     * Afficher une actualité en détail
     */
    public function showActualite($slug)
    {
        $actualite = News::with('images')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Incrémenter le nombre de vues si vous avez un champ views
        // $actualite->increment('views');

        return view('actualite-detail', compact('actualite'));
    }
}