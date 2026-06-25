<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ $title ?? 'Dashboard' }}</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body style="background-color: var(--gray-100);">
    <div class="admin-layout">
        <aside class="sidebar">
            <div style="padding-bottom: 2rem; border-bottom: 1px solid #334155; margin-bottom: 2rem;">
                <a href="{{ route('home') }}" class="logo" style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.1rem;">
                    <img src="{{ asset('logo.png') }}" alt="E-SHOP" style="height: 35px; filter: brightness(0) invert(1);">
                    <span style="color: white;">E-SHOP ADMIN</span>
                </a>
            </div>
            
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge" style="width: 25px;"></i> Dashboard
                </a>
                <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group" style="width: 25px;"></i> Catégories
                </a>
                <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box" style="width: 25px;"></i> Produits
                </a>
                <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-shopping" style="width: 25px;"></i> Commandes
                </a>
                
                <div style="margin-top: 4rem;">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sidebar-link" style="width: 100%; border: none; background: none; text-align: left; cursor: pointer; color: #ef4444;">
                            <i class="fa-solid fa-right-from-bracket" style="width: 25px;"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <main class="main-content">
            <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h1 style="font-size: 1.5rem; font-weight: 700;">@yield('title', 'Tableau de Bord')</h1>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span style="font-weight: 600;">{{ auth()->user()->name }}</span>
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div class="animate-fade-in" style="margin-bottom: 2rem; padding: 1rem; background: #dcfce7; color: #166534; border-radius: 0.5rem; border: 1px solid #bbf7d0;">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
