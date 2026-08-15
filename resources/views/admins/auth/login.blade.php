<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Global Logistics</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/login.css') }}"> --}}
        @vite(['resources/css/login.css', 'resources/js/app.js'])
<link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="{{ asset('images/logo.jpeg') }}"
    />
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo">
               <img src="/images/logo.jpeg" alt="Logo de l'entreprise" class="logo-image">
            </div>
            <h1>Global Logistics</h1>
            <p>Connectez-vous à votre espace admin</p>
        </div>

        <!-- Affichage des messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif

        <!-- Formulaire de connexion -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="exemple@email.com" 
                    required 
                    autofocus
                >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="••••••••" 
                    required
                >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                Se connecter
            </button>
        </form>

        <div class="footer-text">
            <p>&copy; {{ date('Y') }} Global Logistics. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>