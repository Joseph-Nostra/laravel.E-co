@extends('layouts.app')

@section('content')
    <div style="background: white; border-bottom: 1px solid var(--gray-200); padding: 2rem 0;">
        <div class="container">
            <nav style="color: var(--gray-700); font-size: 0.875rem;">
                <a href="{{ route('home') }}">Accueil</a> / <a href="{{ route('shop.index') }}">Boutique</a> / <span style="color: var(--dark);">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <div class="container" style="padding: 4rem 0;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start;">
            <!-- Product Images -->
            <div>
                <div class="card" style="margin-bottom: 1rem;">
                    <img src="{{ $product->images->first()->image ?? 'https://picsum.photos/800/800?random=' . $product->id }}" alt="{{ $product->name }}" style="width: 100%; aspect-ratio: 1; object-fit: cover;">
                </div>
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                    @foreach($product->images as $img)
                        <div class="card" style="cursor: pointer;">
                            <img src="{{ $img->image }}" alt="" style="width: 100%; aspect-ratio: 1; object-fit: cover;">
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Product Info -->
            <div class="animate-fade-in">
                <span style="font-weight: 700; color: var(--primary);">{{ $product->category->name }}</span>
                <h1 style="font-size: 2.5rem; font-weight: 800; margin: 0.5rem 0 1rem;">{{ $product->name }}</h1>
                
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
                    <span style="font-size: 2rem; font-weight: 800; color: var(--dark);">{{ number_format($product->price, 2) }} DH</span>
                    @if($product->stock > 0)
                        <span style="padding: 0.25rem 0.75rem; background: #dcfce7; color: #166534; border-radius: 2rem; font-size: 0.75rem; font-weight: 700;">En Stock</span>
                    @else
                        <span style="padding: 0.25rem 0.75rem; background: #fee2e2; color: #991b1b; border-radius: 2rem; font-size: 0.75rem; font-weight: 700;">Rupture de Stock</span>
                    @endif
                </div>

                <p style="color: var(--gray-700); font-size: 1.125rem; margin-bottom: 2.5rem; line-height: 1.8;">{{ $product->description }}</p>

                <div style="display: flex; gap: 1rem; margin-bottom: 3rem;">
                    <form action="{{ route('cart.add', $product) }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <i class="fa-solid fa-cart-plus"></i> Ajouter au Panier
                        </button>
                    </form>
                    <button class="btn" style="background: white; border: 1px solid var(--gray-200); padding: 1rem;">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </div>

                <div style="border-top: 1px solid var(--gray-200); padding-top: 2rem;">
                    <div style="display: flex; gap: 2rem;">
                        <div>
                            <p style="font-size: 0.875rem; color: var(--gray-700);">Livraison gratuite</p>
                            <p style="font-size: 0.75rem; color: var(--gray-700);">Sur toutes les commandes de plus de 500 DH</p>
                        </div>
                        <div>
                            <p style="font-size: 0.875rem; color: var(--gray-700);">Retour facile</p>
                            <p style="font-size: 0.75rem; color: var(--gray-700);">Dans les 30 jours pour un échange</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div style="margin-top: 6rem;">
            <h2 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 3rem;">Avis des Clients ({{ $product->reviews->count() }})</h2>
            <div style="display: grid; gap: 2rem;">
                @foreach($product->reviews as $review)
                    <div class="glass" style="padding: 2rem; border-radius: 1rem;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                            <div>
                                <h4 style="font-weight: 700;">{{ $review->user->name }}</h4>
                                <div style="color: #f59e0b; margin-top: 0.25rem;">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fa-{{ $i < $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <span style="font-size: 0.875rem; color: var(--gray-700);">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p style="color: var(--gray-700);">{{ $review->comment }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
