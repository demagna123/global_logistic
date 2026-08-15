<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Global Logistics - Contact & Devis</title>
<link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="{{ asset('images/logo.jpeg') }}"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="scroll-progress" id="scrollProgress"></div>

    {{-- navigation --}}
    <header class="navigation navigation--pleine" id="mainNav">
        <div class="logo">
            <img src="/images/logo.jpeg" alt="Logo de l'entreprise" class="logo-image">
        </div>
        <nav class="navbar" id="navbar">
            <a href="/" class="acceuil">Accueil</a>
            <a href="/a-propos" class="propos">A propos</a>
            <a href="/#services" class="nav-services">Nos services</a>
            <a href="/#actualites" class="nav-actualites">Actualités</a>
            <a href="/contact" class="contact">Contact</a>
        </nav>
        <button class="burger" id="burgerBtn">
            <i class="fa-solid fa-bars"></i>
        </button>
    </header>

    {{-- titre de page --}}
    <section class="titre-contact-section">
        <h1>Contactez-nous</h1>
    </section>

    {{-- localisation --}}
    <section class="localisation">
        <div class="carte-map">
            <iframe src="https://www.google.com/maps?q=Zone+Portuaire,+Lomé,+Togo&output=embed" width="100%"
                height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        <div class="coordonnees-rapides">
            <div class="coord-item">
                <i class="fa-solid fa-location-dot"></i>
                <p>Lomé, Zone Portuaire<br>08BP 80159</p>
            </div>
            <div class="coord-item">
                <i class="fa-solid fa-phone"></i>
                <p>+228 90 02 48 75<br>+228 99 25 15 85</p>
            </div>
            <div class="coord-item">
                <i class="fa-solid fa-envelope"></i>
                <p>contact@globallogistics.tg</p>
            </div>
        </div>
    </section>

    {{-- formulaire --}}
    <section class="formulaire-section">
        <form class="form-contact" action="{{ route('contact.store') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" id="telephone" name="telephone" placeholder="+228 XX XX XX XX" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="votre@email.com">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="entreprise">Entreprise (optionnel)</label>
                <div class="input-icon">
                    <i class="fa-solid fa-building"></i>
                    <input type="text" id="entreprise" name="entreprise" placeholder="Nom de votre entreprise">
                </div>
            </div>

            <div class="form-group">
                <label for="service">Quel service vous intéresse ?</label>
                <div class="input-icon">
                    <i class="fa-solid fa-list"></i>
                    <select id="service" name="service" required>
                        <option value="">Sélectionnez un service</option>
                        <option value="transit">Transit & Douane</option>
                        <option value="tierce">Tierce & Détention</option>
                        <option value="representation">Représentation Commerciale</option>
                        <option value="transport">Transport & Logistique</option>
                        <option value="entreposage">Entreposage de Marchandises</option>
                        <option value="import-export">Import & Export</option>
                        <option value="autre">Autre demande</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="message">Description de votre besoin</label>
                <div class="input-icon input-icon--textarea">
                    <i class="fa-solid fa-comment"></i>
                    <textarea id="message" name="message" rows="5" placeholder="Décrivez votre besoin..." required></textarea>
                </div>
            </div>

            <button type="submit" class="btn-envoyer">Envoyer</button>

        </form>
    </section>

    {{-- footer --}}
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
            <a href="/#actualites" class="lien">Actualités</a>
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
    </style>

    @vite(['resources/js/app.js'])
</body>

</html>