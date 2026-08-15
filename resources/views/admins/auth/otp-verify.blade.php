<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vérification OTP - Global Logistics</title>
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

    @vite(['resources/css/otp-verify.css', 'resources/js/app.js'])
</head>

<body>
    <div class="otp-container">
        <div class="otp-icon"><i class="fa-solid fa-lock"></i></div>

        <h1>Vérification en deux étapes</h1>
        <p class="subtitle">Nous avons envoyé un code de vérification à votre adresse email.</p>

        <div class="email-info">
            <i class="fa-solid fa-envelope"></i> {{ session('otp_email') ?? 'email@exemple.com' }}
        </div>

        {{-- Affichage des messages --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Formulaire de vérification OTP --}}
        <form action="{{ route('otpCode-verify') }}" method="POST" id="otpForm">
            @csrf

            <div class="form-group">
                <label for="code">Code OTP (6 chiffres)</label>
                <input type="text" id="code" name="code" class="otp-input" placeholder="• • • • • •"
                    maxlength="6" inputmode="numeric" pattern="[0-9]{6}" required autofocus>
                @error('code')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-verify">
                Vérifier et se connecter
            </button>
        </form>

        <div class="footer-links">
            <form action="{{ route('otpCode-resend') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-resend">
                    <i class="fa-solid fa-rotate-right"></i> Renvoyer le code
                </button>
            </form>

            <a href="{{ route('loginForm') }}"><i class="fa-solid fa-arrow-left"></i> Retour à la connexion</a>
        </div>

        <div class="timer">
            <i class="fa-regular fa-clock"></i> Le code expire dans <span id="countdown">5:00</span>
        </div>
    </div>

    {{-- Script pour le compte à rebours --}}
    <script>
        let timer = 300; // 5 minutes en secondes
        const countdownElement = document.getElementById('countdown');

        function updateTimer() {
            const minutes = Math.floor(timer / 60);
            const seconds = timer % 60;
            countdownElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            if (timer <= 0) {
                countdownElement.textContent = 'Expiré';
                countdownElement.classList.add('expired');
                return;
            }

            timer--;
        }

        setInterval(updateTimer, 1000);

        document.getElementById('code').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (this.value.length === 6) {
                this.form.submit();
            }
        });
    </script>
</body>

</html>