<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Toutes nos actualités - Global Logistics</title>
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

    {{-- Bannière --}}
    <section class="page-banner">
        <div class="banner-content">
            <h1>Nos actualités</h1>
            <p>Restez informés des dernières nouvelles de Global Logistics</p>
        </div>
    </section>

    {{-- Liste des actualités --}}
    <section class="actualites-page">
        <div class="actualites-container">
            @if($actualites->count() > 0)
                <div class="actualites-grid">
                    @foreach($actualites as $actualite)
                        <article class="actu-card">
                            <div class="actu-image">
                                @if($actualite->images->first())
                                    <img src="{{ asset('storage/' . $actualite->images->first()->image_path) }}"
                                         alt="{{ $actualite->title }}">
                                @else
                                    <div class="no-image-placeholder">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                @endif
                                @if($actualite->images->count() > 1)
                                    <span class="image-count-badge">
                                        <i class="fas fa-images"></i> {{ $actualite->images->count() }}
                                    </span>
                                @endif
                            </div>
                            <div class="actu-body">
                                <div class="actu-meta">
                                    <span class="actu-date">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $actualite->published_date->format('d F Y') }}
                                    </span>
                                </div>
                                <h2 class="actu-title">{{ $actualite->title }}</h2>
                                <p class="actu-excerpt">
                                    {{ Str::limit($actualite->excerpt ?? $actualite->content, 150) }}
                                </p>
                                <a href="{{ route('actualite.show', $actualite->slug) }}" class="actu-link">
                                    Lire la suite <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="pagination-container">
                    {{ $actualites->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                    <h2>Aucune actualité pour le moment</h2>
                    <p>Revenez bientôt pour découvrir nos dernières nouvelles.</p>
                </div>
            @endif
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
            <p class="footer__text"><i class="fa-solid fa-envelope"></i> contact@globallogisticsarlu.com</p>
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
.page-banner {
    background-color: var(--bleu-marine);
    padding: 130px 60px 60px;
    text-align: center;
}

.banner-content h1 {
    font-family: 'Playfair Display', serif;
    font-size: 34px;
    font-weight: 700;
    color: var(--blanc);
    margin-bottom: 12px;
}

.banner-content p {
    font-size: 15px;
    color: #C6D0DC;
}

.actualites-page {
    background-color: var(--gris-clair);
    padding: 70px 60px;
}

.actualites-container {
    max-width: 1200px;
    margin: 0 auto;
}

.actualites-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.actu-card {
    background-color: var(--blanc);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(12, 35, 64, 0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.actu-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(12, 35, 64, 0.12);
}

.actu-image {
    position: relative;
    width: 100%;
    height: 190px;
}

.actu-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.no-image-placeholder {
    width: 100%;
    height: 100%;
    background-color: var(--gris-clair);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #B0BAC5;
    font-size: 34px;
}

.image-count-badge {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background-color: rgba(12, 35, 64, 0.75);
    color: var(--blanc);
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.actu-body {
    padding: 22px;
}

.actu-meta {
    margin-bottom: 10px;
}

.actu-date {
    font-size: 12.5px;
    color: #999999;
    display: flex;
    align-items: center;
    gap: 6px;
}

.actu-title {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 700;
    color: var(--bleu-marine);
    margin-bottom: 10px;
    line-height: 1.4;
}

.actu-excerpt {
    font-size: 14px;
    line-height: 1.6;
    color: #666666;
    margin-bottom: 16px;
}

.actu-link {
    color: var(--orange);
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: gap 0.25s ease;
}

.actu-link:hover {
    gap: 12px;
}

.pagination-container {
    margin-top: 50px;
    display: flex;
    justify-content: center;
}

.pagination-container nav {
    display: flex;
    gap: 6px;
}

.pagination-container a,
.pagination-container span {
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 14px;
    color: var(--bleu-marine);
    background-color: var(--blanc);
    border: 1px solid #E0E0E0;
}

.pagination-container a:hover {
    background-color: var(--orange);
    color: var(--blanc);
    border-color: var(--orange);
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-icon {
    font-size: 48px;
    color: #C6D0DC;
    margin-bottom: 20px;
}

.empty-state h2 {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    color: var(--bleu-marine);
    margin-bottom: 10px;
}

.empty-state p {
    color: #999999;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 900px) {
    .page-banner { padding-top: 110px; }
    .actualites-page { padding: 50px 24px; }
    .actualites-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 600px) {
    .actualites-grid { grid-template-columns: 1fr; }
    .banner-content h1 { font-size: 26px; }
}   
    </style>

    @vite(['resources/js/app.js'])
</body>
</html>