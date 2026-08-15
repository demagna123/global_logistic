<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $actualite->title }} - Global Logistics</title>
<link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="{{ asset('images/logo.jpeg') }}"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="scroll-progress" id="scrollProgress"></div>

    {{-- Header --}}
    <header class="navigation navigation--pleine" id="mainNav">
        <div class="logo">
            <img src="/images/logo.jpeg" alt="Logo de l'entreprise" class="logo-image">
        </div>
        <nav class="navbar" id="navbar">
            <a href="/" class="acceuil">Accueil</a>
            <a href="/a-propos" class="propos">A propos</a>
            <a href="/#services" class="nav-services">Nos services</a>
            <a href="{{ route('actualites') }}" class="nav-actualites">Actualités</a>
            <a href="/contact" class="contact">Contact</a>
        </nav>
        <button class="burger" id="burgerBtn">
            <i class="fa-solid fa-bars"></i>
        </button>
    </header>

    {{-- Contenu principal --}}
    <section class="detail-article">
        <div class="detail-container">
            {{-- Fil d'Ariane --}}
            <div class="breadcrumb">
                <a href="/"><i class="fas fa-home"></i> Accueil</a>
                <span class="separator"><i class="fas fa-chevron-right"></i></span>
                <a href="{{ route('actualites') }}">Actualités</a>
                <span class="separator"><i class="fas fa-chevron-right"></i></span>
                <span class="current">{{ $actualite->title }}</span>
            </div>

            {{-- Image principale --}}
            @if($actualite->images->first())
                <div class="article-image-main">
                    <img src="{{ asset('storage/' . $actualite->images->first()->image_path) }}"
                         alt="{{ $actualite->title }}"
                         class="main-image">
                </div>
            @endif

            {{-- En-tête de l'article --}}
            <div class="article-header">
                <h1 class="article-title">{{ $actualite->title }}</h1>
                <div class="article-meta">
                    <span class="meta-item">
                        <i class="far fa-calendar-alt"></i>
                        {{ $actualite->published_date->format('d F Y') }}
                    </span>
                    <span class="meta-item">
                        <i class="far fa-clock"></i>
                        {{ $actualite->published_date->format('H:i') }}
                    </span>
                    @if($actualite->images->count() > 0)
                        <span class="meta-item">
                            <i class="fas fa-images"></i>
                            {{ $actualite->images->count() }} image(s)
                        </span>
                    @endif
                </div>
            </div>

            {{-- Résumé --}}
            @if($actualite->excerpt)
                <div class="article-excerpt">
                    <p>{{ $actualite->excerpt }}</p>
                </div>
            @endif

            {{-- Contenu --}}
            <div class="article-content">
                {!! nl2br(e($actualite->content)) !!}
            </div>

            {{-- Galerie d'images --}}
            @if($actualite->images->count() > 1)
                <div class="article-gallery">
                    <h3><i class="fas fa-images"></i> Galerie d'images</h3>
                    <div class="gallery-grid">
                        @foreach($actualite->images as $index => $image)
                            @if($index > 0)
                                <div class="gallery-item" onclick="openLightbox('{{ asset('storage/' . $image->image_path) }}', '{{ $image->caption ?? 'Image ' . ($index + 1) }}')">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         alt="{{ $image->caption ?? 'Image ' . ($index + 1) }}">
                                    @if($image->caption)
                                        <div class="gallery-caption">{{ $image->caption }}</div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Navigation entre articles --}}
            <div class="article-navigation">
                @php
                    $prev = \App\Models\News::where('is_published', true)
                                ->where('published_date', '<=', now())
                                ->where('id', '<', $actualite->id)
                                ->orderBy('id', 'desc')
                                ->first();

                    $next = \App\Models\News::where('is_published', true)
                                ->where('published_date', '<=', now())
                                ->where('id', '>', $actualite->id)
                                ->orderBy('id', 'asc')
                                ->first();
                @endphp

                @if($prev)
                    <a href="{{ route('actualite.show', $prev->slug) }}" class="nav-prev">
                        <i class="fas fa-arrow-left"></i>
                        <span>
                            <small>Article précédent</small>
                            <strong>{{ $prev->title }}</strong>
                        </span>
                    </a>
                @else
                    <div class="nav-placeholder"></div>
                @endif

                <a href="{{ route('actualites') }}" class="nav-all">
                    <i class="fas fa-th"></i>
                    <span>Toutes les actualités</span>
                </a>

                @if($next)
                    <a href="{{ route('actualite.show', $next->slug) }}" class="nav-next">
                        <span>
                            <small>Article suivant</small>
                            <strong>{{ $next->title }}</strong>
                        </span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @else
                    <div class="nav-placeholder"></div>
                @endif
            </div>

            {{-- Bouton retour --}}
            <div class="back-button">
                <a href="{{ route('actualites') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Retour aux actualités
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="pied-page">
        <div class="peid">
            <div class="pied-logo" style="font-size: 15px">
                <img src="/images/logo.jpeg" alt="Logo GLOBAL LOGISTICS">
                <span>GLOBAL LOGISTICS SERVICES SARL-U</span>
            </div>
            <p class="pied-sologan">Votre partenaire logistique de confiance</p>
        </div>
        <div class="pied-navigation">
            <h4 class="pied-nav">Navigation</h4>
            <a href="/" class="lien">Accueil</a>
            <a href="/a-propos" class="lien">A propos</a>
            <a href="/#services" class="lien">Nos services</a>
            <a href="{{ route('actualites') }}" class="lien">Actualités</a>
            <a href="/contact" class="lien">Contact</a>
        </div>
        <div class="coordonnes">
            <h4 class="pied-contact">Contact</h4>
            <p class="footer__text"><i class="fa-solid fa-location-dot"></i> Lomé, Togo</p>
            <p class="footer__text" style="font-size: 12px;"><i class="fa-solid fa-inbox"></i> 08BP 80159, Lomé Zone Portuaire</p>
            <p class="footer__text"><i class="fa-solid fa-phone" style="font-size: 10px"></i> +228 90 02 48 75/99 25 15 85</p>
            <p class="footer__text"><i class="fa-solid fa-envelope"></i> contact@globallogistics.tg</p>
            <p class="footer__text"><i class="fa-solid fa-file-shield"></i>TG N° 20170015</p>
        </div>
        <div class="footerbas">
    {{-- nom des designeurs --}}
    <div class="design">
        <p class="design-text">Designed & Developed by <span>Ablam DEMAGNA</span> & <span>bernadine-dev</span></p>
    </div>

    <div class="copyright">
        <p class="copyright-text">© 2026 GLOBAL LOGISTICS SERVICES SARL-U. Tous droits réservés.</p>
    </div>
</div>
    </footer>

    {{-- Lightbox --}}
    <div id="lightbox" class="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close"><i class="fas fa-times"></i></span>
        <img class="lightbox-content" id="lightboxImg">
        <div class="lightbox-caption" id="lightboxCaption"></div>
    </div>
</body>
</html>

    <style> 
    .pied-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 15px;
    font-weight: 700;
    color: #fff;
}

.pied-logo img {
    width: 32px;
    height: 32px;
    object-fit: cover;
    border-radius: 55% 25%;
}

.detail-article {
    background-color: var(--gris-clair);
    padding: 130px 60px 80px;
}

.detail-container {
    max-width: 850px;
    margin: 0 auto;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: #888888;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.breadcrumb a {
    color: #888888;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: color 0.2s ease;
}

.breadcrumb a:hover {
    color: var(--orange);
}

.breadcrumb .separator {
    font-size: 10px;
    color: #C6D0DC;
}

.breadcrumb .current {
    color: var(--bleu-marine);
    font-weight: 600;
}

.article-image-main {
    width: 100%;
    height: 380px;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 35px;
    box-shadow: 0 10px 30px rgba(12, 35, 64, 0.1);
}

.article-image-main .main-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.article-header {
    margin-bottom: 25px;
}

.article-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    font-weight: 700;
    color: var(--bleu-marine);
    line-height: 1.3;
    margin-bottom: 16px;
}

.article-meta {
    display: flex;
    gap: 22px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 7px;
    font-size: 13.5px;
    color: #999999;
}

.meta-item i {
    color: var(--orange);
}

.article-excerpt {
    background-color: var(--blanc);
    border-left: 4px solid var(--orange);
    padding: 18px 22px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.article-excerpt p {
    font-size: 16px;
    font-style: italic;
    color: var(--bleu-marine);
    line-height: 1.6;
}

.article-content {
    background-color: var(--blanc);
    padding: 35px;
    border-radius: 16px;
    font-size: 16px;
    line-height: 1.9;
    color: var(--gris-texte);
    margin-bottom: 40px;
    box-shadow: 0 4px 16px rgba(12, 35, 64, 0.05);
}

/* Galerie */
.article-gallery {
    margin-bottom: 40px;
}

.article-gallery h3 {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    color: var(--bleu-marine);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.article-gallery h3 i {
    color: var(--orange);
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.gallery-item {
    position: relative;
    height: 140px;
    border-radius: 10px;
    overflow: hidden;
    cursor: pointer;
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.gallery-item:hover img {
    transform: scale(1.08);
}

.gallery-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(12, 35, 64, 0.75);
    color: var(--blanc);
    font-size: 11.5px;
    padding: 6px 10px;
}

/* Navigation entre articles */
.article-navigation {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    gap: 16px;
    margin-bottom: 30px;
}

.nav-prev, .nav-next, .nav-all {
    background-color: var(--blanc);
    border-radius: 12px;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 2px 10px rgba(12, 35, 64, 0.05);
}

.nav-prev:hover, .nav-next:hover, .nav-all:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(12, 35, 64, 0.1);
}

.nav-next {
    justify-content: flex-end;
    text-align: right;
}

.nav-prev i, .nav-next i {
    color: var(--orange);
    font-size: 14px;
}

.nav-prev span, .nav-next span {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.nav-prev small, .nav-next small {
    font-size: 11px;
    color: #999999;
}

.nav-prev strong, .nav-next strong {
    font-size: 13.5px;
    color: var(--bleu-marine);
    line-height: 1.3;
}

.nav-all {
    flex-direction: column;
    justify-content: center;
    text-align: center;
    color: var(--bleu-marine);
    font-size: 13px;
    font-weight: 600;
}

.nav-all i {
    color: var(--orange);
    font-size: 18px;
    margin-bottom: 4px;
}

.nav-placeholder {
    visibility: hidden;
}

.back-button {
    text-align: center;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: transparent;
    border: 2px solid var(--bleu-marine);
    color: var(--bleu-marine);
    padding: 12px 28px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    transition: background-color 0.25s ease, color 0.25s ease;
}

.btn-back:hover {
    background-color: var(--bleu-marine);
    color: var(--blanc);
}

/* Lightbox */
.lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(12, 35, 64, 0.92);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.lightbox.active {
    display: flex;
}

.lightbox-content {
    max-width: 85%;
    max-height: 75vh;
    border-radius: 8px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
}

.lightbox-caption {
    color: var(--blanc);
    font-size: 14px;
    margin-top: 16px;
    text-align: center;
}

.lightbox-close {
    position: absolute;
    top: 25px;
    right: 35px;
    color: var(--blanc);
    font-size: 26px;
    cursor: pointer;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s ease;
}

.lightbox-close:hover {
    background-color: rgba(255, 255, 255, 0.2);
}

/* Responsive */
@media (max-width: 900px) {
    .detail-article { padding: 110px 24px 60px; }
    .article-title { font-size: 24px; }
    .article-image-main { height: 240px; }
    .article-content { padding: 24px; }
    .gallery-grid { grid-template-columns: repeat(2, 1fr); }
    .article-navigation { grid-template-columns: 1fr; }
    .nav-next { justify-content: flex-start; text-align: left; }
}
    </style>

    <script>
        // Lightbox
        function openLightbox(src, caption) {
            const lightbox = document.getElementById('lightbox');
            const img = document.getElementById('lightboxImg');
            const captionEl = document.getElementById('lightboxCaption');
            
            img.src = src;
            captionEl.textContent = caption || 'Image';
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

        // Animation au scroll
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });
            
            elements.forEach(el => observer.observe(el));
        });
    </script>

    @vite(['resources/js/app.js'])
</body>
</html>