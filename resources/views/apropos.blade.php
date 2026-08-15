<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Global Logistics - A propos</title>
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

    {{-- navigation --}}
        <header class="navigationpropos">
            <div class="logopropos">
                <img src="/images/logo.jpeg" alt="Logo de l'entreprise" class="logo-image">
            </div>
            <nav class="navbar" id="navbar">
    <a href="/" class="acceuil" style="color: (--orange)">Accueil</a>
    <a href="/a-propos" class="propos">A propos</a>
    <a href="/#services" class="nav-services">Nos services</a>
    <a href="/#actualites" class="nav-actualites">Actualités</a>
    <a href="/contact" class="contact">Contact</a>
</nav>
<button class="burger" id="burgerBtn">
    <i class="fa-solid fa-bars"></i>
</button>
        </header>

    {{-- à propos --}}
    <section class="apropos">

        <div class="titre-propos">
            <h1>À propos de nous</h1>
        </div>

        <div class="contenu-propos">

            <div class="propos-image">
                <img src="/images/entrepot.jpg" alt="entrepot global-logistics">
            </div>

            <div class="propos-texte">
                <p>
                    Optimisez vos flux, sécurisez vos stocks et développez
                    votre business sans frontières avec GLOBAL LOGISTICS SERVICES SARL-U.
                </p>
                <p>
                    Nous ne faisons pas que transporter des marchandises, nous connectons
                    votre entreprise aux marchés mondiaux avec une efficacité absolue.
                    Du transit douanier à la gestion stratégique de vos stocks en entreposage
                    et tierce détention, notre équipe maîtrise chaque maillon de la supply chain
                    internationale. En prenant en charge votre représentation commerciale et vos
                    flux d'import-export, nous transformons les barrières logistiques en véritables
                    accélérateurs de croissance pour votre activité.
                </p>
                <p>
                    Notre service vous garantie la sécurité et conformité douanière absolue,
                    la rapidité opérationnelle maximale pour accélérer vos livraisons,
                    des solutions sur mesure adaptées à vos produits, et une transparence totale
                    avec un suivi clair de vos opérations.
                </p>
                <p>
                    GLOBAL LOGISTICS SERVICES SARL-U met son expertise de pointe au service
                    de la sécurité de vos affaires. Vous cherchez un partenaire fiable pour
                    propulser vos échanges commerciaux ?
                </p>
            </div>

        </div>

        <div class="propos-bouton">
            <button class="contact"><a href="/contact">Contactez-nous</a></button>
        </div>

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
            <a href="{{ route('actualites') }}" class="lien">Actualités</a>
            <a href="/contact" class="lien">Contact</a>
        </div>
        <div class="coordonnes">
            <h4 class="pied-contact">Contact</h4>
            <p class="footer__text"><i class="fa-solid fa-location-dot"></i> Lomé, Togo</p>
            <p class="footer__text" style="font-size: 12px;"><i class="fa-solid fa-inbox"></i> 08BP 80159, Lomé Zone Portuaire</p>
            <p class="footer__text"><i class="fa-solid fa-phone" style="font-size: 10px"></i> +228 90 02 48 75/99 25 15 85</p>
            <p class="footer__text"><i class="fa-solid fa-envelope"></i> contact@globallogisticsarlu.com</p>
            <p class="footer__text"><i class="fa-solid fa-file-shield"></i> TG N° 20170015</p>
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