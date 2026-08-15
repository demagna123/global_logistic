<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Détail de l'actualité - Global Logistics</title>
    <link rel="stylesheet" href="{{ asset('css/admin/news-show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
            @vite(['resources/css/new-show.css', 'resources/js/admin-news-form.js'])

</head>
<body>
    <div class="container">
        <!-- En-tête -->
        <div class="page-header">
            <div>
                <h1>📄 Détail de l'actualité</h1>
                <p class="subtitle">Consultez toutes les informations de l'actualité</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admins.news.edit', $news->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('admins.news.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Contenu principal -->
        <div class="show-container">
            <!-- Informations générales -->
            <div class="info-card">
                <div class="card-header">
                    <h2><i class="fas fa-info-circle"></i> Informations générales</h2>
                    <span class="status-badge {{ $news->is_published ? 'published' : 'draft' }}">
                        <i class="fas {{ $news->is_published ? 'fa-check-circle' : 'fa-pen' }}"></i>
                        {{ $news->is_published ? 'Publié' : 'Brouillon' }}
                    </span>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <label>ID</label>
                        <span>#{{ $news->id }}</span>
                    </div>

                    <div class="info-item">
                        <label>Titre</label>
                        <span>{{ $news->title }}</span>
                    </div>

                    <div class="info-item">
                        <label>Slug</label>
                        <span class="slug-value">{{ $news->slug }}</span>
                    </div>

                    <div class="info-item">
                        <label>Date de publication</label>
                        <span>
                            <i class="far fa-calendar-alt"></i>
                            {{ $news->published_date->format('d/m/Y') }}
                            à
                            {{ $news->published_date->format('H:i') }}
                        </span>
                    </div>

                    <div class="info-item">
                        <label>Date de création</label>
                        <span>
                            <i class="far fa-clock"></i>
                            {{ $news->created_at->format('d/m/Y H:i') }}
                        </span>
                    </div>

                    <div class="info-item">
                        <label>Dernière modification</label>
                        <span>
                            <i class="far fa-clock"></i>
                            {{ $news->updated_at->format('d/m/Y H:i') }}
                        </span>
                    </div>

                    <div class="info-item full-width">
                        <label>Nombre d'images</label>
                        <span>
                            <i class="fas fa-images"></i>
                            {{ $news->images->count() }} / 3
                        </span>
                    </div>
                </div>
            </div>

            <!-- Résumé -->
            <div class="content-card">
                <div class="card-header">
                    <h2><i class="fas fa-align-left"></i> Résumé</h2>
                </div>
                <div class="content-body">
                    @if($news->excerpt)
                        <p>{{ $news->excerpt }}</p>
                    @else
                        <p class="empty-text"><i class="fas fa-minus-circle"></i> Aucun résumé renseigné</p>
                    @endif
                </div>
            </div>

            <!-- Contenu complet -->
            <div class="content-card">
                <div class="card-header">
                    <h2><i class="fas fa-file-alt"></i> Contenu complet</h2>
                </div>
                <div class="content-body">
                    <div class="full-content">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="images-card">
                <div class="card-header">
                    <h2><i class="fas fa-images"></i> Images</h2>
                    <span class="image-count-badge">{{ $news->images->count() }} / 3</span>
                </div>

                @if($news->images->count() > 0)
                    <div class="images-grid">
                        @foreach($news->images as $index => $image)
                            <div class="image-item">
                                <div class="image-wrapper">
                                    <img 
                                        src="{{ asset('storage/' . $image->image_path) }}" 
                                        alt="{{ $image->caption ?? $news->title . ' - Image ' . ($index + 1) }}"
                                        onclick="openLightbox(this.src, '{{ $image->caption ?? 'Image ' . ($index + 1) }}')"
                                    >
                                    <div class="image-order">{{ $index + 1 }}</div>
                                    @if($loop->first)
                                        <div class="image-main-badge">
                                            <i class="fas fa-star"></i> Principale
                                        </div>
                                    @endif
                                </div>
                                <div class="image-caption">
                                    <i class="fas fa-quote-left"></i>
                                    {{ $image->caption ?? 'Aucune légende' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-images">
                        <div class="empty-icon">🖼️</div>
                        <p>Aucune image associée à cette actualité</p>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="actions-card">
                <div class="card-header">
                    <h2><i class="fas fa-cog"></i> Actions</h2>
                </div>
                <div class="actions-grid">
                    <a href="{{ route('admins.news.edit', $news->id) }}" class="action-btn edit-btn">
                        <i class="fas fa-edit"></i>
                        <span>Modifier l'actualité</span>
                    </a>

                    <form action="{{ route('admins.news.toggle-publish', $news->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="action-btn {{ $news->is_published ? 'unpublish-btn' : 'publish-btn' }}">
                            <i class="fas {{ $news->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            <span>{{ $news->is_published ? 'Dépublier' : 'Publier' }}</span>
                        </button>
                    </form>

                    <form action="{{ route('admins.news.destroy', $news->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette actualité ? Cette action est irréversible.')">
                            <i class="fas fa-trash-alt"></i>
                            <span>Supprimer</span>
                        </button>
                    </form>

                    <a href="{{ route('admins.news.index') }}" class="action-btn back-btn">
                        <i class="fas fa-arrow-left"></i>
                        <span>Retour à la liste</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Lightbox pour les images -->
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close">&times;</span>
        <img class="lightbox-content" id="lightboxImg">
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>

    <script>
        // Lightbox
        function openLightbox(src, caption) {
            const lightbox = document.getElementById('lightbox');
            const img = document.getElementById('lightboxImg');
            const captionEl = document.getElementById('lightboxCaption');
            
            img.src = src;
            captionEl.textContent = caption;
            lightbox.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const lightbox = document.getElementById('lightbox');
            lightbox.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Fermer avec la touche Echap
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });
    </script>
</body>
</html>