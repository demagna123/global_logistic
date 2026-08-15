@extends('layouts.admin')

@section('title', 'Modifier l\'actualité - Global Logistics')

@section('header-title', 'Modifier l\'actualité')

@section('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @endsection
    @vite(['resources/css/news-form.css', 'resources/js/admins/news-form.js'])

@section('content')
<div class="form-container">
    <div class="form-card">
        <h1><i class="fa-solid fa-pen-to-square"></i> Modifier l'actualité</h1>
        <p class="subtitle">Modifiez les informations de l'actualité</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admins.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Titre --}}
            <div class="form-group">
                <label for="title">Titre <span class="required">*</span></label>
                <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}"
                    placeholder="Ex: Arrivage de nouveaux conteneurs au port de Lomé" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Résumé --}}
            <div class="form-group">
                <label for="excerpt">Résumé</label>
                <textarea id="excerpt" name="excerpt" rows="3" placeholder="Un bref résumé de l'actualité">{{ old('excerpt', $news->excerpt) }}</textarea>
                @error('excerpt')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Contenu --}}
            <div class="form-group">
                <label for="content">Contenu <span class="required">*</span></label>
                <textarea id="content" name="content" rows="8" placeholder="Rédigez le contenu complet de l'actualité..."
                    required>{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- Date + Statut --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="published_date">Date de publication <span class="required">*</span></label>
                    <input type="date" id="published_date" name="published_date"
                        value="{{ old('published_date', $news->published_date->format('Y-m-d')) }}" required>
                    @error('published_date')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_published">Statut</label>
                    <div class="toggle-group">
                        <input type="checkbox" id="is_published" name="is_published" value="1"
                            {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                        <label for="is_published">Publier immédiatement</label>
                    </div>
                    <div class="help-text">Si coché, l'actualité sera visible sur le site.</div>
                </div>
            </div>

            {{-- Images existantes --}}
            @if ($news->images->count() > 0)
                <div class="form-group">
                    <label>Images existantes</label>
                    <div class="existing-images">
                        @foreach ($news->images as $image)
                            <div class="existing-image-item">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    alt="{{ $image->caption ?? 'Image' }}">
                                <span class="order-badge">{{ $loop->iteration }}</span>
                                <button type="button" class="delete-check"
                                    onclick="toggleDeleteImage(this, {{ $image->id }})">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                                <div class="image-info">
                                    <input type="text" name="existing_images[{{ $image->id }}]"
                                        value="{{ old('existing_images.' . $image->id, $image->caption) }}"
                                        placeholder="Légende de l'image" maxlength="255">
                                    <input type="hidden" name="delete_images[]"
                                        id="delete_image_{{ $image->id }}" value="">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="help-text">Cliquez sur la croix pour marquer une image à supprimer.</div>
                </div>
            @endif

            {{-- Ajouter de nouvelles images --}}
            <div class="form-group">
                <label>Ajouter des images (max 3 au total)</label>

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
                <div class="help-text">Ajoutez jusqu'à 3 images au total. La première sera l'image principale.</div>
            </div>

            {{-- Boutons --}}
            <div class="btn-group">
                <button type="submit" class="btn btn-success">
                    <i class="fa-solid fa-check"></i> Mettre à jour
                </button>
                <a href="{{ route('admins.news.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Annuler
                </a>
                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $news->id }})">
                    <i class="fa-solid fa-trash"></i> Supprimer
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Form de suppression caché --}}
<form id="deleteForm" action="{{ route('admins.news.destroy', $news->id) }}" method="POST"
    style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
    <script>
        function toggleDeleteImage(button, imageId) {
            button.classList.toggle('active');
            const hiddenInput = document.getElementById(`delete_image_${imageId}`);

            if (button.classList.contains('active')) {
                hiddenInput.value = imageId;
                button.innerHTML = '<i class="fa-solid fa-check"></i>';
            } else {
                hiddenInput.value = '';
                button.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            }
        }

        function confirmDelete(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette actualité ? Cette action est irréversible.')) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
    @vite(['resources/js/admins/news-form.js'])
@endsection