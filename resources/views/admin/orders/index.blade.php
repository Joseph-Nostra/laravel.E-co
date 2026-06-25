@extends('layouts.admin')

@section('title', 'Gestion des Commandes')

@section('content')
    <div class="glass" style="padding: 2rem; border-radius: 1rem;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid var(--gray-200); color: var(--gray-700);">
                    <th style="padding: 1.5rem 1rem;">ID</th>
                    <th style="padding: 1.5rem 1rem;">Client</th>
                    <th style="padding: 1.5rem 1rem;">Total</th>
                    <th style="padding: 1.5rem 1rem;">Statut</th>
                    <th style="padding: 1.5rem 1rem;">Date</th>
                    <th style="padding: 1.5rem 1rem;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 1.5rem 1rem; font-weight: 700;">#{{ $order->id }}</td>
                        <td style="padding: 1.5rem 1rem;">
                            <div style="font-weight: 600;">{{ $order->user->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--gray-700);">{{ $order->user->email }}</div>
                        </td>
                        <td style="padding: 1.5rem 1rem; font-weight: 800;">{{ number_format($order->total_price, 2) }} DH</td>
                        <td style="padding: 1.5rem 1rem;">
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                @csrf
                                <select name="status" onchange="this.form.submit()" style="padding: 0.4rem 0.75rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; border: none;
                                    @if($order->status == 'pending') background: #fef9c3; color: #854d0e;
                                    @elseif($order->status == 'processing') background: #dbeafe; color: #1e40af;
                                    @elseif($order->status == 'completed') background: #dcfce7; color: #166534;
                                    @else background: #fee2e2; color: #991b1b; @endif">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>PENDING</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>PROCESSING</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>COMPLETED</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>CANCELLED</option>
                                </select>
                            </form>
                        </td>
                        <td style="padding: 1.5rem 1rem; color: var(--gray-700);">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td style="padding: 1.5rem 1rem;">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn" style="background: var(--light); color: var(--primary); padding: 0.5rem 1rem; border: 1px solid var(--primary);">
                                Voir Détails
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 2rem;">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
