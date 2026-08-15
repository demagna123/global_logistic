<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GLOBAL LOGISTICS - Accueil</title>
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
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="scroll-progress" id="scrollProgress"></div>

    {{-- section Accueil --}}
     <header class="navigation" id="mainNav">
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
    <section class="hero">
        <br> 
         <br> 
          <br> 
           <br> 
        <div class="content">
            <h1 class="anim-1">GLOBAL LOGISTICS SERVICES SARL-U</h1>
            <p class="anim-2">Votre partenaire de confiance pour 
                simplifier vos flux, maîtriser vos détails
                votre chaîne logistique devient notre priorité absolue. 
            </p>
            <a href="/contact" class="devis anim-3" >Demander un Devis</a>
        </div>
    </section>

    {{-- section service --}}
    <section class="services" id="services">
        <h1>Nous vous accompagnons dans divers domaines tels que:</h1>
        <div class="domaines">

        <div class="service-domaine fade-in">
            <div class="flip-inner">
                <div class="flip-front">
                    <i class="fa-solid fa-file-shield service-card__icon"></i>
                    <h3 class="titre">Transit & Douane</h3>
                    <p class="description"> le voyage sécurisé de vos
                        marchandises d'une frontière à l'autre, sans
                        payer de taxes avant l'arrivée
                    </p>
                    <button class="savoir">En savoir plus</button>
                </div>
                <div class="flip-back">
                    <button class="retour"><i class="fa-solid fa-arrow-left"></i></button>
                    <img src="/images/services/transit-douane.jpg" alt="Transit douane" class="service-card__image-back">
                    <p class="description-back">
                        Nous gérons l'intégralité de vos formalités douanières : déclarations,
                        classification tarifaire, calcul et paiement des droits, et coordination
                        avec les autorités portuaires, pour un passage rapide et 100% conforme.
                    </p>
                    <a href="/contact" class="contact-btn">Nous contacter</a>
                </div>
            </div>
        </div>

        <div class="service-domaine fade-in">
            <div class="flip-inner">
                <div class="flip-front">
                    <i class="fa-solid fa-warehouse service-card__icon"></i>
                    <h3 class="titre">Tierce & Détention</h3>
                    <p class="description"> Nous gardons et surveillons
                        vos marchandises en toute sécurité pour servir
                        de garantie de confiance entre vous et vos partenaires
                        financiers
                    </p>
                    <button class="savoir">En savoir plus</button>
                </div>
                <div class="flip-back">
                    <button class="retour"><i class="fa-solid fa-arrow-left"></i></button>
                    <img src="/images/services/tierce-detention.jpg" alt="Tierce détention" class="service-card__image-back">
                    <p class="description-back">
                        Vos marchandises sont entreposées dans nos installations sécurisées et
                        surveillées en continu, servant de garantie tangible dans vos accords
                        commerciaux et financiers, avec un suivi rigoureux à chaque étape.
                    </p>
                    <a href="/contact" class="contact-btn">Nous contacter</a>
                </div>
            </div>
        </div>

        <div class="service-domaine fade-in">
            <div class="flip-inner">
                <div class="flip-front">
                    <i class="fa-solid fa-handshake service-card__icon"></i>
                    <h3 class="titre">Représentation Commerciale</h3>
                    <p class="description">
                        Un service d'externalisation commerciale permettant
                        le déploiement opérationnel, l'acquisition de clients
                        et la gestion d'affaires sur un marché cible sans structure
                        locale permanente
                    </p>
                    <button class="savoir">En savoir plus</button>
                </div>
                <div class="flip-back">
                    <button class="retour"><i class="fa-solid fa-arrow-left"></i></button>
                    {{-- <img src="/images/services/representation-commerciale.jpg" alt="Représentation commerciale" class="service-card__image-back"> --}}
                    <p class="description-back">
                        Nous agissons comme votre relais local : prospection, négociation et
                        gestion d'affaires, sans que vous ayez besoin d'une structure permanente
                        sur place. Votre présence commerciale, sans les contraintes logistiques.
                    </p>
                    <a href="/contact" class="contact-btn">Nous contacter</a>
                </div>
            </div>
        </div>

        <div class="service-domaine fade-in">
            <div class="flip-inner">
                <div class="flip-front">
                    <i class="fa-solid fa-truck-fast service-card__icon"></i>
                    <h3 class="titre">Transport & Logistique</h3>
                    <p class="description">
                        L'organisation technique du fret multimodal
                        assurant la fluidité des flux de marchandises,
                        la traçabilité des cargaisons et la synchronisation
                        parfaite entre les points de production et de
                        livraison
                    </p>
                    <button class="savoir">En savoir plus</button>
                </div>
                <div class="flip-back">
                    <button class="retour"><i class="fa-solid fa-arrow-left"></i></button>
                    <img src="/images/services/transport-logistique.jpeg" alt="Transport logistique" class="service-card__image-back">
                    <p class="description-back">
                        Nous synchronisons chaque étape entre production et livraison :
                        routier, maritime, multimodal. Traçabilité en temps réel et respect
                        strict des délais, pour une chaîne logistique sans accroc.
                    </p>
                    <a href="/contact" class="contact-btn">Nous contacter</a>
                </div>
            </div>
        </div>

        <div class="service-domaine fade-in">
            <div class="flip-inner">
                <div class="flip-front">
                    <i class="fa-solid fa-boxes-stacked service-card__icon"></i>
                    <h3 class="titre"> Entreposage de Marchandises</h3>
                    <p class="description">
                        Une solution de stockage stratégique dotée d'infrastructures
                        adaptées, assurant la réception, le magasinage,
                        la traçabilité rigoureuse et la préparation
                        des marchandises avant leur distribution
                    </p>
                    <button class="savoir">En savoir plus</button>
                </div>
                <div class="flip-back">
                    <button class="retour"><i class="fa-solid fa-arrow-left"></i></button>
                    <img src="/images/services/entreposage.jpg" alt="Entreposage" class="service-card__image-back">
                    <p class="description-back">
                        Nos entrepôts modernes et sécurisés accueillent vos marchandises avec
                        une gestion précise des stocks, une préparation soignée avant expédition,
                        et un accès facilité à tout moment pour vos équipes.
                    </p>
                    <a href="/contact" class="contact-btn">Nous contacter</a>
                </div>
            </div>
        </div>

        <div class="service-domaine fade-in">
            <div class="flip-inner">
                <div class="flip-front">
                    <i class="fa-solid fa-ship service-card__icon"></i>
                    <h3 class="titre"> Import & Export</h3>
                    <p class="description">
                        Encadrement des transactions transfrontalières,
                        combinant la négociation d'achats internationaux,
                        la sécurisation des échanges et la conformité
                        stricte aux réglementations commerciales mondiales
                    </p>
                    <button class="savoir">En savoir plus</button>
                </div>
                <div class="flip-back">
                    <button class="retour"><i class="fa-solid fa-arrow-left"></i></button>
                    <img src="/images/services/import-export.jpg" alt="Import export" class="service-card__image-back">
                    <p class="description-back">
                        De la négociation avec vos fournisseurs internationaux à la sécurisation
                        des paiements et la conformité douanière, nous encadrons chaque
                        transaction transfrontalière avec rigueur et transparence.
                    </p>
                    <a href="/contact" class="contact-btn">Nous contacter</a>
                </div>
            </div>
        </div>
    </section>

    {{-- Actualites --}}
   <section class="actualites" id="actualites">
    <h1 class="actu">Dernières Actualités</h1>
    <div class="dernier-actu">
        @forelse($actualites as $actualite)
            <article class="toutactualistes fade-in">
                <div class="image">
                    @if($actualite->images->first())
                        <img src="{{ asset('storage/' . $actualite->images->first()->image_path) }}" 
                             alt="{{ $actualite->title }}"
                             style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px 8px 0 0;">
                    @else
                        <div style="width: 100%; height: 200px; background: #e2e8f0; display: flex; align-items: center; justify-content: center; color: #a0aec0; border-radius: 8px 8px 0 0;">
                            <i class="fas fa-image" style="font-size: 40px;"></i>
                        </div>
                    @endif
                </div>
                <span class="date">{{ $actualite->published_date->format('d F Y') }}</span>
                <h3 class="nouvaute">{{ $actualite->title }}</h3>
                <p style="padding: 0 15px 15px; color: #4a5568; font-size: 14px; line-height: 1.6;">
                    {{ Str::limit($actualite->excerpt ?? $actualite->content, 120) }}
                </p>
                <a href="{{ route('actualite.show', $actualite->slug) }}" 
                   style="display: inline-block; margin: 0 15px 15px; color: #1a365d; font-weight: 600; text-decoration: none;">
                    Lire la suite →
                </a>
            </article>
        @empty
            <article class="toutactualistes fade-in" style="text-align: center; padding: 40px;">
                <div style="font-size: 48px; margin-bottom: 15px;">📭</div>
                <h3 style="color: #4a5568;">Aucune actualité pour le moment</h3>
                <p style="color: #a0aec0;">Revenez bientôt pour découvrir nos dernières nouvelles.</p>
            </article>
        @endforelse
    </div>
</section>

    {{-- footer --}}
   <footer class="pied-page">
    <div class="peid">
        <div class="pied-logo" style="font-size: 12px">
            <img src="/images/logo.jpeg" alt="Logo GLOBAL LOGISTICS">
            <span>GLOBAL LOGISTICS SERVICES SARL-U</span>
            <!-- Petit cadenas discret -->
            <a href="{{ route('loginForm') }}" class="admin-lock" title="Accès administrateur">
                <i class="fa-solid fa-lock" style="font-size: 10px; color: rgba(255,255,255,0.2); margin-left: 5px;"></i>
            </a>
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
           <br> 
    <div class="copyright">
        <p class="copyright-text">© 2026 GLOBAL LOGISTICS SERVICES SARL-U. Tous droits réservés.</p>
    </div>
</div>
</footer>
    <style>
.hero{
    min-height:630px;
    background-image: url("{{ asset('images/fondimage.jpeg') }}");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 630px;
    display: flex;
    flex-direction: column;
    padding: 0 80px;
}

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
</style>
@vite(['resources/js/app.js'])
</body>
</html>