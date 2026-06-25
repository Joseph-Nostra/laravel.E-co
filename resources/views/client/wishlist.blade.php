@extends('layouts.app')

@section('content')
    <div style="background: white; border-bottom: 1px solid var(--gray-200); padding: 2rem 0;">
        <div class="container">
            <h1 style="font-size: 2rem; font-weight: 800;">Mes Préférés (Wishlist)</h1>
        </div>
    </div>

    <div class="container" style="padding: 4rem 0;">
        @if($wishlist->isEmpty())
            <div style="text-align: center; padding: 4rem; background: white; border-radius: 1rem;">
                <i class="fa-solid fa-heart" style="font-size: 4rem; color: var(--gray-200); margin-bottom: 2rem;"></i>
                <h2>Votre liste de souhaits est vide</h2>
                <p style="color: var(--gray-700); margin-bottom: 2rem;">Ajoutez des articles que vous aimez pour les retrouver plus tard.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">Explorer la Boutique</a>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 2rem;">
                @foreach($wishlist as $item)
                    <div class="glass product-card" style="padding: 1.5rem; border-radius: 1.5rem;">
                        <img src="{{ $item->product->images->first()->image ?? 'https://via.placeholder.com/300' }}" style="width: 100%; aspect-ratio: 1; object-fit: cover; border-radius: 1rem; margin-bottom: 1.5rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $item->product->name }}</h3>
                        <p style="color: var(--primary); font-weight: 800; font-size: 1.1rem; margin-bottom: 1.5rem;">{{ number_format($item->product->price, 2) }} DH</p>
                        
                        <div style="display: flex; gap: 1rem;">
                            <form action="{{ route('cart.add', $item->product) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="width: 100%;">Ajouter au Panier</button>
                            </form>
                            <button onclick="toggleWishlist({{ $item->product->id }}, this)" class="btn" style="background: #fee2e2; color: #ef4444;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    function toggleWishlist(id, btn) {
        fetch(`/wishlist/toggle/${id}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => window.location.reload());
    }
</script>
@endsection
