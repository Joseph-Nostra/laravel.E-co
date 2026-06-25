@extends('layouts.app')

@section('content')
    <div style="background: white; border-bottom: 1px solid var(--gray-200); padding: 2rem 0;">
        <div class="container">
            <h1 style="font-size: 2rem; font-weight: 800;">Validation de la Commande</h1>
        </div>
    </div>

    <div class="container" style="padding: 4rem 0;">
        <form action="{{ route('checkout.process') }}" method="POST" style="display: grid; grid-template-columns: 1fr 400px; gap: 4rem;">
            @csrf
            <!-- Billing Details -->
            <div class="glass" style="padding: 3rem; border-radius: 1.5rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem;">Informations de Livraison</h2>
                
                <div style="display: grid; gap: 1.5rem;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Adresse Complète</label>
                        <input type="text" name="address" required style="width: 100%; padding: 0.875rem 1rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Ville</label>
                            <input type="text" name="city" required style="width: 100%; padding: 0.875rem 1rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Téléphone</label>
                            <input type="tel" name="phone" required style="width: 100%; padding: 0.875rem 1rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;">
                        </div>
                    </div>
                </div>

                <h2 style="font-size: 1.5rem; font-weight: 700; margin: 3rem 0 2rem;">Mode de Paiement</h2>
                <div class="glass" style="padding: 1.5rem; border-radius: 1rem; border: 2px solid var(--primary); display: flex; align-items: center; gap: 1rem;">
                    <i class="fa-solid fa-money-bill-wave" style="font-size: 1.5rem; color: var(--primary);"></i>
                    <div>
                        <p style="font-weight: 700;">Paiement à la livraison</p>
                        <p style="font-size: 0.875rem; color: var(--gray-700);">Payez en espèces dès que vous recevez votre colis.</p>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <aside>
                <div class="glass" style="padding: 2.5rem; border-radius: 1.5rem; position: sticky; top: 100px;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 2rem;">Récapitulatif</h3>
                    <div style="display: grid; gap: 1.5rem; margin-bottom: 2rem;">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php $total += $item['price'] * $item['quantity']; @endphp
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <img src="{{ $item['image'] }}" style="width: 50px; height: 50px; border-radius: 0.5rem; object-fit: cover;">
                                    <div>
                                        <p style="font-weight: 600; font-size: 0.875rem;">{{ $item['name'] }}</p>
                                        <p style="font-size: 0.75rem; color: var(--gray-700);">x{{ $item['quantity'] }}</p>
                                    </div>
                                </div>
                                <span style="font-weight: 600;">{{ number_format($item['price'] * $item['quantity'], 2) }} DH</span>
                            </div>
                        @endforeach
                    </div>

                    <div style="border-top: 1px solid var(--gray-200); padding-top: 1.5rem; display: grid; gap: 1rem;">
                        <div style="margin-bottom: 2rem; border-bottom: 1px solid var(--gray-200); padding-bottom: 1.5rem;">
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Code Promo</label>
                            <div style="display: flex; gap: 0.5rem;">
                                <input type="text" id="coupon-code" style="flex: 1; padding: 0.5rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
                                <button type="button" onclick="applyCoupon()" class="btn" style="padding: 0.5rem 1rem; border: 1px solid var(--primary); color: var(--primary);">Appliquer</button>
                            </div>
                            <p id="coupon-msg" style="font-size: 0.75rem; margin-top: 0.25rem;"></p>
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: var(--gray-700);">
                            <span>Sous-total</span>
                            <span>{{ number_format($total, 2) }} DH</span>
                        </div>
                        @if(session('coupon'))
                            <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; color: #166534; font-weight: 600;">
                                <span>Remise ({{ session('coupon')['code'] }})</span>
                                <span>- {{ session('coupon')['type'] == 'fixed' ? number_format(session('coupon')['value'], 2) . ' DH' : session('coupon')['value'] . '%' }}</span>
                            </div>
                        @endif
                        <div style="display: flex; justify-content: space-between; color: #166534; font-weight: 600;">
                            <span>Livraison</span>
                            <span>Gratuite</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: 800; margin-top: 1rem; border-top: 1px solid var(--gray-200); padding-top: 1.5rem;">
                            <span>Total</span>
                            <span>{{ number_format($total, 2) }} DH</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1.25rem; margin-top: 2.5rem; font-size: 1.125rem;">Confirmer la Commande</button>
                    <p style="text-align: center; font-size: 0.75rem; color: var(--gray-700); margin-top: 1rem;">En confirmant, vous acceptez nos conditions générales de vente.</p>
                </div>
            </aside>
        </form>
    </div>
<script>
    function applyCoupon() {
        const code = document.getElementById('coupon-code').value;
        const msg = document.getElementById('coupon-msg');
        
        fetch("{{ route('checkout.coupon') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: code })
        })
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                msg.style.color = '#ef4444';
                msg.innerText = data.error;
            } else {
                msg.style.color = '#166534';
                msg.innerText = data.success;
                setTimeout(() => window.location.reload(), 1000);
            }
        });
    }
</script>
@endsection
