@extends('layouts.admin')

@section('title', 'Détails de la Commande #' . $order->id)

@section('content')
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.orders.index') }}" style="color: var(--gray-700);"><i class="fa-solid fa-arrow-left"></i> Retour à la liste</a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem; align-items: start;">
        <div class="glass" style="padding: 3rem; border-radius: 1.5rem;">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 2rem;">Produits Commandés</h3>
            <div style="display: grid; gap: 1.5rem;">
                @foreach($order->items as $item)
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--gray-100); padding-bottom: 1rem;">
                        <div style="display: flex; align-items: center; gap: 1.5rem;">
                            <div style="width: 70px; height: 70px; border-radius: 0.75rem; background: var(--gray-100); display: flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-box" style="font-size: 1.5rem; color: var(--gray-700);"></i>
                            </div>
                            <div>
                                <h4 style="font-weight: 700; font-size: 1.125rem;">{{ $item->product->name }}</h4>
                                <p style="color: var(--gray-700);">{{ number_format($item->price, 2) }} DH x {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <span style="font-weight: 800; font-size: 1.125rem;">{{ number_format($item->price * $item->quantity, 2) }} DH</span>
                    </div>
                @endforeach
            </div>

            <div style="margin-top: 3rem; text-align: right;">
                <p style="color: var(--gray-700); font-weight: 600;">Total de la Commande</p>
                <p style="font-size: 2.5rem; font-weight: 900; color: var(--primary);">{{ number_format($order->total_price, 2) }} DH</p>
            </div>
        </div>

        <aside>
            <div class="glass" style="padding: 2.5rem; border-radius: 1.5rem; margin-bottom: 2rem;">
                <h3 style="font-size: 1.125rem; font-weight: 800; margin-bottom: 1.5rem;">Client</h3>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.25rem;">
                        {{ substr($order->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p style="font-weight: 700;">{{ $order->user->name }}</p>
                        <p style="font-size: 0.875rem; color: var(--gray-700);">{{ $order->user->email }}</p>
                    </div>
                </div>
                
                <h3 style="font-size: 1.125rem; font-weight: 800; margin-bottom: 1rem;">Expédition</h3>
                <div style="background: var(--light); padding: 1.5rem; border-radius: 1rem; font-size: 0.9375rem;">
                    <p style="margin-bottom: 0.5rem;"><i class="fa-solid fa-location-dot" style="width: 20px; color: var(--primary);"></i> {{ $order->address }}</p>
                    <p style="margin-bottom: 0.5rem;"><i class="fa-solid fa-city" style="width: 20px; color: var(--primary);"></i> {{ $order->city }}</p>
                    <p><i class="fa-solid fa-phone" style="width: 20px; color: var(--primary);"></i> {{ $order->phone }}</p>
                </div>
            </div>

            <div class="glass" style="padding: 2.5rem; border-radius: 1.5rem;">
                <h3 style="font-size: 1.125rem; font-weight: 800; margin-bottom: 1.5rem;">Statut</h3>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf
                    <select name="status" style="width: 100%; padding: 0.875rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none; margin-bottom: 1.5rem;">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>En cours</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Terminée</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Mettre à Jour</button>
                </form>
            </div>
        </aside>
    </div>
@endsection
