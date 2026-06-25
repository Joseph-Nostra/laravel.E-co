@extends('layouts.admin')

@section('title', 'Tableau de Bord')

@section('content')
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div class="glass" style="padding: 2rem; border-radius: 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="color: var(--gray-700); font-weight: 600;">Total Revenu</p>
                    <h2 style="font-size: 1.75rem; font-weight: 800; margin-top: 0.5rem;">{{ number_format($totalRevenue, 2) }} DH</h2>
                </div>
                <div style="width: 50px; height: 50px; border-radius: 0.75rem; background: #dcfce7; color: #166534; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fa-solid fa-sack-dollar"></i>
                </div>
            </div>
        </div>

        <div class="glass" style="padding: 2rem; border-radius: 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="color: var(--gray-700); font-weight: 600;">Commandes</p>
                    <h2 style="font-size: 1.75rem; font-weight: 800; margin-top: 0.5rem;">{{ $totalOrders }}</h2>
                </div>
                <div style="width: 50px; height: 50px; border-radius: 0.75rem; background: #dbeafe; color: #1e40af; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>
        </div>

        <div class="glass" style="padding: 2rem; border-radius: 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="color: var(--gray-700); font-weight: 600;">Produits</p>
                    <h2 style="font-size: 1.75rem; font-weight: 800; margin-top: 0.5rem;">{{ $totalProducts }}</h2>
                </div>
                <div style="width: 50px; height: 50px; border-radius: 0.75rem; background: #fef9c3; color: #854d0e; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>
        </div>

        <div class="glass" style="padding: 2rem; border-radius: 1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="color: var(--gray-700); font-weight: 600;">Clients</p>
                    <h2 style="font-size: 1.75rem; font-weight: 800; margin-top: 0.5rem;">{{ $totalUsers }}</h2>
                </div>
                <div style="width: 50px; height: 50px; border-radius: 0.75rem; background: #fae8ff; color: #86198f; display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="glass" style="padding: 2rem; border-radius: 1rem;">
        <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 2rem;">Commandes Récentes</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid var(--gray-200); color: var(--gray-700);">
                    <th style="padding: 1rem;">ID</th>
                    <th style="padding: 1rem;">Client</th>
                    <th style="padding: 1rem;">Total</th>
                    <th style="padding: 1rem;">Statut</th>
                    <th style="padding: 1rem;">Date</th>
                    <th style="padding: 1rem;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 1rem;">#{{ $order->id }}</td>
                        <td style="padding: 1rem; font-weight: 600;">{{ $order->user->name }}</td>
                        <td style="padding: 1rem;">{{ number_format($order->total_price, 2) }} DH</td>
                        <td style="padding: 1rem;">
                            <span style="padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.75rem; font-weight: 700;
                                @if($order->status == 'pending') background: #fef9c3; color: #854d0e;
                                @elseif($order->status == 'completed') background: #dcfce7; color: #166534;
                                @else background: #f1f5f9; color: var(--gray-700); @endif">
                                {{ strtoupper($order->status) }}
                            </span>
                        </td>
                        <td style="padding: 1rem; color: var(--gray-700);">{{ $order->created_at->diffForHumans() }}</td>
                        <td style="padding: 1rem;">
                            <a href="{{ route('admin.orders.show', $order) }}" style="color: var(--primary); font-weight: 600;">Détails</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
