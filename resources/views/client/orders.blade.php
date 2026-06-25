@extends('layouts.app')

@section('content')
    <div style="background: white; border-bottom: 1px solid var(--gray-200); padding: 2rem 0;">
        <div class="container">
            <h1 style="font-size: 2rem; font-weight: 800;">Mes Commandes</h1>
        </div>
    </div>

    <div class="container" style="padding: 4rem 0;">
        @if($orders->isEmpty())
            <div style="text-align: center; padding: 4rem; background: white; border-radius: 1rem;">
                <i class="fa-solid fa-box-open" style="font-size: 4rem; color: var(--gray-200); margin-bottom: 2rem;"></i>
                <h2>Vous n'avez pas encore de commandes</h2>
                <p style="color: var(--gray-700); margin-bottom: 2rem;">Vos commandes apparaîtront ici une fois validées.</p>
                <a href="{{ route('shop.index') }}" class="btn btn-primary">Découvrir nos produits</a>
            </div>
        @else
            <div style="display: grid; gap: 2rem;">
                @foreach($orders as $order)
                    <div class="glass" style="padding: 2.5rem; border-radius: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--gray-100);">
                            <div>
                                <h3 style="font-size: 1.25rem; font-weight: 800;">Commande #{{ $order->id }}</h3>
                                <p style="font-size: 0.875rem; color: var(--gray-700);">Passée le {{ $order->created_at->format('d M Y à H:i') }}</p>
                            </div>
                            <div style="text-align: right;">
                                <span style="display: inline-block; padding: 0.5rem 1rem; border-radius: 2rem; font-weight: 700; font-size: 0.875rem; 
                                    @if($order->status == 'pending') background: #fef9c3; color: #854d0e;
                                    @elseif($order->status == 'processing') background: #dbeafe; color: #1e40af;
                                    @elseif($order->status == 'completed') background: #dcfce7; color: #166534;
                                    @else background: #fee2e2; color: #991b1b; @endif">
                                    {{ strtoupper($order->status) }}
                                </span>
                            </div>
                        </div>

                        <div style="display: grid; gap: 1.5rem; margin-bottom: 2rem;">
                            @foreach($order->items as $item)
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="width: 60px; height: 60px; border-radius: 0.5rem; background: var(--gray-100); display: flex; align-items: center; justify-content: center;">
                                            <i class="fa-solid fa-box" style="color: var(--gray-700);"></i>
                                        </div>
                                        <div>
                                            <p style="font-weight: 700;">{{ $item->product->name }}</p>
                                            <p style="font-size: 0.875rem; color: var(--gray-700);">Quantité: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <span style="font-weight: 600;">{{ number_format($item->price, 2) }} DH</span>
                                </div>
                            @endforeach
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1.5rem; border-top: 1px solid var(--gray-100);">
                            <div style="font-size: 0.875rem; color: var(--gray-700);">
                                <p><i class="fa-solid fa-location-dot"></i> {{ $order->address }}, {{ $order->city }}</p>
                                <p><i class="fa-solid fa-phone"></i> {{ $order->phone }}</p>
                            </div>
                            <div style="text-align: right;">
                                <p style="font-size: 0.875rem; color: var(--gray-700);">Total Payé</p>
                                <p style="font-size: 1.5rem; font-weight: 800;">{{ number_format($order->total_price, 2) }} DH</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
