@extends('layouts.admin')

@section('title', 'Créer une actualité - Global Logistics')

@section('header-title', 'Créer une actualité')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/news-form.css') }}">
    @endsection
    @vite(['resources/css/news-form.css', 'resources/js/admins/news-form.js'])

@section('content')
    <div class="form-container">
        <div class="form-card">
            <h1><i class="fa-solid fa-newspaper"></i> Créer une nouvelle actualité</h1>
            <p class="subtitle">Remplissez tous les champs pour publier une actualité</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admins.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Titre --}}
                <div class="form-group">
                    <label for="title">Titre <span class="required">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        placeholder="Ex: Arrivage de nouveaux conteneurs au port de Lomé" required>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Résumé --}}
                <div class="form-group">
                    <label for="excerpt">Résumé</label>
                    <textarea id="excerpt" name="excerpt" rows="3"
                        placeholder="Un bref résumé de l'actualité (apparaît dans la liste)">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Optionnel. Si non renseigné, un extrait du contenu sera généré automatiquement.</div>
                </div>

                {{-- Contenu --}}
                <div class="form-group">
                    <label for="content">Contenu <span class="required">*</span></label>
                    <textarea id="content" name="content" rows="8" placeholder="Rédigez le contenu complet de l'actualité..."
                        required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Date + Statut --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="published_date">Date de publication <span class="required">*</span></label>
                        <input type="date" id="published_date" name="published_date"
                            value="{{ old('published_date', date('Y-m-d')) }}" required>
                        @error('published_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="is_published">Statut</label>
                        <div class="toggle-group">
                            <input type="checkbox" id="is_published" name="is_published" value="1"
                                {{ old('is_published') ? 'checked' : '' }}>
                            <label for="is_published">Publier immédiatement</label>
                        </div>
                        <div class="help-text">Si coché, l'actualité sera visible sur le site immédiatement.</div>
                    </div>
                </div>

                {{-- Images --}}
                <div class="form-group">
                    <label>Images (max 3)</label>

                    <div class="image-upload-area" id="imageUploadArea">
                        <div class="icon"><i class="fa-solid fa-image"></i></div>
                        <p>Cliquez pour ajouter des images</p>
                        <span class="hint">Formats acceptés : JPG, PNG, GIF (max 2MB)</span>
                        <input type="file" id="images" name="images[]" accept="image/*" multiple
                            style="display: none;">
                    </div>

                    <div class="image-preview-container" id="imagePreviewContainer"></div>

                    @error('images')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <div class="help-text">Ajoutez jusqu'à 3 images. La première image sera utilisée comme image principale.</div>
                </div>

                {{-- Boutons --}}
                <div class="btn-group">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-check"></i> PUBLIER
                    </button>
                    <a href="{{ route('admins.news.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Annuler et retourner
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection