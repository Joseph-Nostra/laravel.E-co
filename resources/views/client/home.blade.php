@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section style="background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); padding: 6rem 0; text-align: center;">
        <div class="container animate-fade-in">
            <h1 style="font-size: 4rem; font-weight: 800; margin-bottom: 1.5rem; letter-spacing: -0.05em;">Style & Confort <br><span style="color: var(--primary);">Réinventés</span></h1>
            <p style="font-size: 1.25rem; color: var(--gray-700); max-width: 600px; margin: 0 auto 2.5rem;">Découvrez notre collection exclusive de produits premium conçus pour sublimer votre quotidien.</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('shop.index') }}" class="btn btn-primary">Acheter Maintenant</a>
                <a href="#featured" class="btn" style="background: white; color: var(--dark); border: 1px solid var(--gray-200);">Voir les Nouveautés</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section style="padding: 5rem 0;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
                <div>
                    <h2 style="font-size: 2rem; font-weight: 700;">Nos Catégories</h2>
                    <p style="color: var(--gray-700);">Explorez nos différentes gammes de produits.</p>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem;">
                @foreach($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->id]) }}" class="card" style="height: 200px; display: flex; align-items: center; justify-content: center; position: relative;">
                        <img src="{{ $category->image ?? 'https://picsum.photos/400/300?random=' . $loop->index }}" alt="{{ $category->name }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.8; filter: brightness(0.6);">
                        <h3 style="position: relative; color: white; font-size: 2rem; z-index: 1;">{{ $category->name }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" style="padding: 5rem 0; background: white;">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
                <div>
                    <h2 style="font-size: 2rem; font-weight: 700;">Produits en Vedette</h2>
                    <p style="color: var(--gray-700);">Une sélection de nos meilleurs produits pour vous.</p>
                </div>
                <a href="{{ route('shop.index') }}" style="color: var(--primary); font-weight: 600;">Voir tout <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                @foreach($featuredProducts as $product)
                    <div class="card animate-fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <img src="{{ $product->images->first()->image ?? 'https://picsum.photos/500/500?random=' . $product->id }}" alt="{{ $product->name }}" class="card-img">
                        </a>
                        <div class="card-body">
                            <span style="font-size: 0.875rem; color: var(--primary); font-weight: 600;">{{ $product->category->name }}</span>
                            <h3 style="font-size: 1.125rem; margin: 0.5rem 0;">{{ $product->name }}</h3>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                                <span style="font-size: 1.25rem; font-weight: 800;">{{ number_format($product->price, 2) }} DH</span>
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="padding: 0.5rem; border-radius: 50%; width: 40px; height: 40px;">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section style="padding: 5rem 0;">
        <div class="container">
            <div class="glass" style="padding: 4rem; border-radius: 2rem; display: flex; flex-direction: column; align-items: center; text-align: center;">
                <h2 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem;">Restez Informé</h2>
                <p style="color: var(--gray-700); max-width: 500px; margin-bottom: 2rem;">Inscrivez-vous à notre newsletter pour recevoir nos dernières offres et nouveautés en exclusivité.</p>
                <form style="display: flex; gap: 0.5rem; width: 100%; max-width: 450px;">
                    <input type="email" placeholder="Votre adresse email" style="flex: 1; padding: 1rem 1.5rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;">
                    <button type="button" class="btn btn-primary">S'abonner</button>
                </form>
            </div>
        </div>
    </section>
@endsection
