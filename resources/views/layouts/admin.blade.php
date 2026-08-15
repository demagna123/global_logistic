<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Administration - Global Logistics')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="{{ asset('images/logo.jpeg') }}"
    />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin/layout.css') }}">
    @vite(['resources/css/layout.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="brand-icon">GL</div>
                <div class="brand-text">
                    <span class="brand-title">Global Logistics</span>
                    <span class="brand-subtitle">Administration</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li>
                        <a href="{{ route('admins.dashboard') }}" class="{{ request()->routeIs('admins.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-pie"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li class="nav-divider">Gestion</li>
                    <li>
                        <a href="{{ route('admins.news.index') }}" class="{{ request()->routeIs('admins.news.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper"></i>
                            <span>Actualités</span>
                            <span class="badge">{{ \App\Models\News::count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admins.quotes.index') }}" class="{{ request()->routeIs('admins.quotes.*') ? 'active' : '' }}">
                            <i class="fas fa-file-invoice"></i>
                            <span>Devis</span>
                            <span class="badge">{{ \App\Models\Quote::count() }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admins.contacts.index') }}" class="{{ request()->routeIs('admins.contacts.*') ? 'active' : '' }}">
                            <i class="fas fa-envelope"></i>
                            <span>Messages</span>
                            <span class="badge badge-danger">{{ \App\Models\Contact::unread()->count() }}</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenu principal -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2>@yield('header-title', 'Administration')</h2>
                </div>
                <div class="header-right">
                    <div class="admin-user">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="admin-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <script>
        // Toggle sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        });

        // Responsive: fermer la sidebar sur mobile
        if (window.innerWidth <= 768) {
            document.getElementById('sidebar').classList.add('collapsed');
        }
    </script>
    @stack('scripts')
</body>
</html>