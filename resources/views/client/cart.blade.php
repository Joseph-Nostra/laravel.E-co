@extends('layouts.app')

@section('content')
    <div style="background: white; border-bottom: 1px solid var(--gray-200); padding: 2rem 0;">
        <div class="container">
            <h1 style="font-size: 2rem; font-weight: 800;">Votre Panier</h1>
        </div>
    </div>

    <div class="container" style="padding: 4rem 0;">
        @if(empty($cart))
            <div style="text-align: center; padding: 4rem; background: white; border-radius: 1rem;">
                <i class="fa-solid fa-cart-shopping" style="font-size: 4rem; color: var(--gray-200); margin-bottom: 2rem;"></i>
                <h2>Votre panier est vide</h2>
                <p style="color: var(--gray-700); margin-bottom: 2rem;">Il est temps de commencer vos achats !</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">Retour à la Boutique</a>
            </div>
        @else
            <div style="display: grid; grid-template-columns: 1fr 350px; gap: 3rem; align-items: start;">
                <div class="glass" style="padding: 2rem; border-radius: 1rem;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 1px solid var(--gray-200);">
                                <th style="padding-bottom: 1rem;">Produit</th>
                                <th style="padding-bottom: 1rem;">Prix</th>
                                <th style="padding-bottom: 1rem;">Quantité</th>
                                <th style="padding-bottom: 1rem;">Total</th>
                                <th style="padding-bottom: 1rem;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cart as $id => $details)
                                @php $total += $details['price'] * $details['quantity']; @endphp
                                <tr style="border-bottom: 1px solid var(--gray-100);">
                                    <td style="padding: 1.5rem 0;">
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <img src="{{ $details['image'] }}" style="width: 60px; height: 60px; border-radius: 0.5rem; object-fit: cover;">
                                            <span style="font-weight: 600;">{{ $details['name'] }}</span>
                                        </div>
                                    </td>
                                    <td>{{ number_format($details['price'], 2) }} DH</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <input type="number" value="{{ $details['quantity'] }}" min="1" class="qty-input" data-id="{{ $id }}" style="width: 60px; padding: 0.25rem 0.5rem; border-radius: 0.25rem; border: 1px solid var(--gray-200);">
                                        </div>
                                    </td>
                                    <td style="font-weight: 700;">{{ number_format($details['price'] * $details['quantity'], 2) }} DH</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf
                                            <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <aside>
                    <div class="glass" style="padding: 2rem; border-radius: 1rem;">
                        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.5rem;">Résumé</h3>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: var(--gray-700);">
                            <span>Sous-total</span>
                            <span>{{ number_format($total, 2) }} DH</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 1.5rem; border-bottom: 1px solid var(--gray-200); padding-bottom: 1rem;">
                            <span>Livraison</span>
                            <span style="color: #166534; font-weight: 600;">Gratuite</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; font-size: 1.25rem; font-weight: 800;">
                            <span>Total</span>
                            <span>{{ number_format($total, 2) }} DH</span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="width: 100%;">Passer au Paiement</a>
                    </div>
                </aside>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function() {
            let id = this.getAttribute('data-id');
            let quantity = this.value;
            fetch("/cart/update/" + id, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: quantity })
            }).then(() => window.location.reload());
        });
    });
</script>
@endsection
