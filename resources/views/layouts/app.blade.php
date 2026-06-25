<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'E-Shop' }}</title>
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar glass">
        <div class="container nav-content">
            <a href="{{ route('home') }}" class="logo" style="display: flex; align-items: center; gap: 0.5rem;">
                <img src="{{ asset('logo.png') }}" alt="E-SHOP" style="height: 45px;">
                <span>E-SHOP</span>
            </a>
            
            <ul style="display: flex; gap: 2rem; align-items: center;">
                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li><a href="{{ route('shop.index') }}">Boutique</a></li>
                <li style="position: relative;">
                    <div style="display: flex; align-items: center; background: rgba(255,255,255,0.5); padding: 0.5rem 1rem; border-radius: 2rem; border: 1px solid var(--gray-200);">
                        <i class="fa-solid fa-magnifying-glass" style="margin-right: 0.5rem; color: var(--gray-700);"></i>
                        <input type="text" id="main-search" placeholder="Rechercher..." style="background: none; border: none; outline: none; width: 150px;">
                    </div>
                    <div id="search-results" class="glass" style="position: absolute; top: 100%; left: 0; width: 300px; margin-top: 0.5rem; display: none; z-index: 100; border-radius: 1rem; overflow: hidden;"></div>
                </li>
                @auth
                    <li><a href="{{ route('orders.index') }}">Mes Commandes</a></li>
                    @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">Dashboard</a></li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: none; border: none; cursor: pointer; color: var(--secondary); font-weight: 600;">Déconnexion</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Connexion</a></li>
                    <li><a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.5rem 1rem;">S'inscrire</a></li>
                @endauth
                <li>
                    <a href="{{ route('cart.index') }}" style="position: relative;">
                        <i class="fa-solid fa-cart-shopping"></i>
                        @if(session('cart') && count(session('cart')) > 0)
                            <span style="position: absolute; top: -10px; right: -10px; background: var(--secondary); color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.75rem;">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="container animate-fade-in" style="margin-top: 1rem; padding: 1rem; background: #dcfce7; color: #166534; border-radius: 0.5rem; border: 1px solid #bbf7d0;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="container animate-fade-in" style="margin-top: 1rem; padding: 1rem; background: #fee2e2; color: #991b1b; border-radius: 0.5rem; border: 1px solid #fecaca;">
                {{ session('error') }}
            </div>
        @endif

        <script>
            function toggleWishlist(productId) {
                fetch(`/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'added') {
                        alert('Ajouté à la liste de souhaits !');
                    } else {
                        alert('Retiré de la liste de souhaits.');
                    }
                    window.location.reload();
                });
            }
        </script>

        <script>
            const searchInput = document.getElementById('main-search');
            const searchResults = document.getElementById('search-results');

            searchInput.addEventListener('input', function() {
                const query = this.value;
                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }

                fetch(`{{ route('search.autocomplete') }}?q=${query}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            searchResults.innerHTML = data.map(p => `
                                <a href="/product/${p.slug}" style="display: block; padding: 1rem; border-bottom: 1px solid var(--gray-100); color: var(--dark); text-decoration: none;">
                                    <div style="font-weight: 700;">${p.name}</div>
                                    <div style="font-size: 0.8rem; color: var(--primary);">${p.price} DH</div>
                                </a>
                            `).join('');
                            searchResults.style.display = 'block';
                        } else {
                            searchResults.style.display = 'none';
                        }
                    });
            });

            document.addEventListener('click', (e) => {
                if (!searchInput.contains(e.target)) searchResults.style.display = 'none';
            });
        </script>

        @yield('content')
    </main>

    <footer style="background: var(--dark); color: white; padding: 4rem 0; margin-top: 4rem;">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem;">
            <div>
                <a href="{{ route('home') }}" class="logo" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <img src="{{ asset('logo.png') }}" alt="E-SHOP" style="height: 40px; filter: brightness(0) invert(1);">
                    <span style="color: white;">E-SHOP</span>
                </a>
                <p style="color: #94a3b8;">La meilleure destination pour vos achats en ligne avec une expérience premium.</p>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem;">Liens Rapides</h4>
                <ul style="color: #94a3b8; display: flex; flex-direction: column; gap: 0.5rem;">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('shop.index') }}">Boutique</a></li>
                    <li><a href="{{ route('cart.index') }}">Panier</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1.5rem;">Contact</h4>
                <ul style="color: #94a3b8; display: flex; flex-direction: column; gap: 0.5rem;">
                    <li><i class="fa-solid fa-location-dot"></i> Rabat, Maroc</li>
                    <li><i class="fa-solid fa-phone"></i> +212 600 000 000</li>
                    <li><i class="fa-solid fa-envelope"></i> contact@e-shop.com</li>
                </ul>
            </div>
        </div>
        <div class="container" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #334155; text-align: center; color: #64748b;">
            <p>&copy; 2026 E-SHOP. Tous droits réservés.</p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
