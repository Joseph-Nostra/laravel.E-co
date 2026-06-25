@extends('layouts.app')

@section('content')
    <div style="background: white; border-bottom: 1px solid var(--gray-200); padding: 2rem 0;">
        <div class="container">
            <h1 style="font-size: 2rem; font-weight: 800;">Boutique</h1>
            <nav style="color: var(--gray-700); font-size: 0.875rem; margin-top: 0.5rem;">
                <a href="{{ route('home') }}">Accueil</a> / <span style="color: var(--dark);">Boutique</span>
            </nav>
        </div>
    </div>

    <div class="container" style="padding: 4rem 0; display: grid; grid-template-columns: 280px 1fr; gap: 3rem;">
        <!-- Filters Sidebar -->
        <aside>
            <div style="margin-bottom: 3rem;">
                <h3 style="font-size: 1.125rem; margin-bottom: 1.5rem;">Rechercher</h3>
                <form action="{{ route('shop.index') }}" method="GET">
                    <div style="position: relative;">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Ex: Montre..." style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;">
                        <button type="submit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-700);">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div style="margin-bottom: 3rem;">
                <h3 style="font-size: 1.125rem; margin-bottom: 1.5rem;">Catégories</h3>
                <ul style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <li>
                        <a href="{{ route('shop.index') }}" style="{{ !request('category') ? 'color: var(--primary); font-weight: 700;' : '' }}">
                            Toutes les catégories
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop.index', ['category' => $category->id]) }}" style="{{ request('category') == $category->id ? 'color: var(--primary); font-weight: 700;' : '' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Products Grid -->
        <div>
            @if($products->isEmpty())
                <div style="text-align: center; padding: 4rem; background: white; border-radius: 1rem;">
                    <i class="fa-solid fa-box-open" style="font-size: 4rem; color: var(--gray-200); margin-bottom: 2rem;"></i>
                    <h2>Aucun produit trouvé</h2>
                    <p style="color: var(--gray-700);">Réessayez avec d'autres filtres ou mots-clés.</p>
                </div>
            @else
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 2rem;">
                    @foreach($products as $product)
                        <div class="card animate-fade-in">
                            <a href="{{ route('shop.show', $product->slug) }}">
                                <img src="{{ $product->images->first()->image ?? 'https://picsum.photos/500/500?random=' . $product->id }}" alt="{{ $product->name }}" class="card-img">
                            </a>
                            <div class="card-body">
                                <h3 style="font-size: 1rem; margin-bottom: 0.5rem;">{{ $product->name }}</h3>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-weight: 800;">{{ number_format($product->price, 2) }} DH</span>
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" style="color: var(--primary); background: none; border: none; cursor: pointer; font-size: 1.25rem;">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top: 4rem;">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
