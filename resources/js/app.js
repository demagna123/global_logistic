// Défilement doux pour les liens du menu
document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href.length > 1) {
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        }
    });
});

// Apparition en fondu des cartes au scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.15 });

document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
});

// Flip des cartes de service
document.querySelectorAll('.savoir').forEach(btn => {
    btn.addEventListener('click', () => {
        btn.closest('.service-domaine').classList.add('flipped');
    });
});

document.querySelectorAll('.retour').forEach(btn => {
    btn.addEventListener('click', () => {
        btn.closest('.service-domaine').classList.remove('flipped');
    });
});

// Validation visuelle douce du formulaire contact
const formContact = document.querySelector('.form-contact');
if (formContact) {
    formContact.addEventListener('submit', function (e) {
        const champs = formContact.querySelectorAll('[required]');
        let valide = true;

        champs.forEach(champ => {
            const wrapper = champ.closest('.input-icon');
            if (!champ.value.trim()) {
                valide = false;
                wrapper.classList.add('erreur');
            } else {
                wrapper.classList.remove('erreur');
            }
        });

        if (!valide) {
            e.preventDefault();
        }
    });
}
// Menu hamburger mobile
const burgerBtn = document.getElementById('burgerBtn');
const navbar = document.getElementById('navbar');

if (burgerBtn && navbar) {
    burgerBtn.addEventListener('click', () => {
        navbar.classList.toggle('open');
        burgerBtn.classList.toggle('active');
    });

    // Ferme le menu si on clique sur un lien
    navbar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            navbar.classList.remove('open');
            burgerBtn.classList.remove('active');
        });
    });
}

// Nav sticky qui change d'apparence au scroll
const mainNav = document.getElementById('mainNav');
if (mainNav) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 60) {
            mainNav.classList.add('scrolled');
        } else {
            mainNav.classList.remove('scrolled');
        }
    });
}

// Barre de progression du scroll
const scrollProgress = document.getElementById('scrollProgress');
if (scrollProgress) {
    window.addEventListener('scroll', () => {
        const hauteurTotale = document.documentElement.scrollHeight - window.innerHeight;
        const pourcentage = (window.scrollY / hauteurTotale) * 100;
        scrollProgress.style.width = pourcentage + '%';
    });
}