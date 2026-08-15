<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Afficher la liste des actualités
     */
    public function index()
    {
        $news = News::with('images')->orderBy('published_date', 'desc')->paginate(10);
        return view('admins.news.index', compact('news'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('admins.news.create');
    }

    /**
     * Enregistrer une nouvelle actualité
     */
    public function store(Request $request)
    {
        // 1. Valider les données
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'published_date' => 'required|date',
            'is_published' => 'boolean',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'captions' => 'nullable|array|max:3',
            'captions.*' => 'nullable|string|max:255'
        ]);

        // 2. Créer l'actualité
        $news = News::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'published_date' => $request->published_date,
            'is_published' => $request->has('is_published') ? true : false
        ]);

        // 3. Gérer les images (max 3)
        if ($request->hasFile('images')) {
            $order = 0;
            foreach ($request->file('images') as $index => $image) {
                // Vérifier la limite de 3 images
                if ($order >= 3) break;

                // Stocker l'image
                $path = $image->store('news', 'public');

                // Créer l'entrée dans la table news_images
                NewsImage::create([
                    'news_id' => $news->id,
                    'image_path' => $path,
                    'caption' => $request->captions[$index] ?? null,
                    'order' => $order
                ]);

                $order++;
            }
        }

        // 4. Rediriger avec message de succès
        return redirect()->route('admins.news.index')
            ->with('success', 'Actualité créée avec succès !');
    }

    /**
     * Afficher une actualité spécifique
     */
    public function show(string $id)
    {
        $news = News::with('images')->findOrFail($id);
        return view('admins.news.show', compact('news'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(string $id)
    {
        $news = News::with('images')->findOrFail($id);
        return view('admins.news.edit', compact('news'));
    }

    /**
     * Mettre à jour une actualité
     */
    public function update(Request $request, string $id)
    {
        $news = News::findOrFail($id);

        // 1. Valider les données
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'published_date' => 'required|date',
            'is_published' => 'boolean',
            'images' => 'nullable|array|max:3',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'captions' => 'nullable|array|max:3',
            'captions.*' => 'nullable|string|max:255',
            'existing_images' => 'nullable|array',
            'delete_images' => 'nullable|array'
        ]);

        // 2. Mettre à jour l'actualité
        $news->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'published_date' => $request->published_date,
            'is_published' => $request->has('is_published') ? true : false
        ]);

        // 3. Supprimer les images sélectionnées
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = NewsImage::find($imageId);
                if ($image && $image->news_id == $news->id) {
                    // Supprimer le fichier physique
                    Storage::disk('public')->delete($image->image_path);
                    // Supprimer l'entrée en base
                    $image->delete();
                }
            }
        }

        // 4. Ajouter de nouvelles images (max 3 au total)
        $currentImageCount = $news->images()->count();
        $maxNewImages = 3 - $currentImageCount;

        if ($request->hasFile('images') && $maxNewImages > 0) {
            $order = $currentImageCount;
            foreach ($request->file('images') as $index => $image) {
                if ($order >= 3) break;

                $path = $image->store('news', 'public');

                NewsImage::create([
                    'news_id' => $news->id,
                    'image_path' => $path,
                    'caption' => $request->captions[$index] ?? null,
                    'order' => $order
                ]);

                $order++;
            }
        }

        // 5. Mettre à jour les légendes des images existantes
        if ($request->has('existing_images')) {
            foreach ($request->existing_images as $imageId => $caption) {
                $image = NewsImage::find($imageId);
                if ($image && $image->news_id == $news->id) {
                    $image->update(['caption' => $caption]);
                }
            }
        }

        return redirect()->route('admins.news.index')
            ->with('success', 'Actualité mise à jour avec succès !');
    }

    /**
     * Supprimer une actualité
     */

    public function destroy(string $id)
    {
        $news = News::findOrFail($id);

        // 1. Supprimer les images physiques
        foreach ($news->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        // 2. Supprimer les entrées en base (cascade grâce à onDelete('cascade'))
        // Les images seront supprimées automatiquement
        $news->delete();

        return redirect()->route('admins.news.index')
            ->with('success', 'Actualité supprimée avec succès !');
    }

    /**
     * Changer le statut de publication (publier/dépublier)
     */
    
    public function togglePublish(string $id)
    {
        $news = News::findOrFail($id);
        $news->is_published = !$news->is_published;
        $news->save();

        $status = $news->is_published ? 'publiée' : 'dépubliée';
        return redirect()->route('admins.news.index')
            ->with('success', "Actualité {$status} avec succès !");
    }
}
