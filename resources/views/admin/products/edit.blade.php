@extends('layouts.admin')

@section('title', 'Modifier le Produit')

@section('content')
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.products.index') }}" class="btn" style="background: var(--gray-200); color: var(--dark);">
            <i class="fa-solid fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="glass" style="padding: 2rem; border-radius: 1rem; max-width: 800px;">
        <h3 style="margin-bottom: 2rem;">Détails du Produit : {{ $product->name }}</h3>
        
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            @csrf
            @method('PUT')
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nom</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Catégorie</label>
                <select name="category_id" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Prix (DH)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
            </div>
            
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
            </div>
            
            <div style="grid-column: span 2;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">{{ old('description', $product->description) }}</textarea>
            </div>
            
            <div style="grid-column: span 2; display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">Mettre à jour le Produit</button>
            </div>
        </form>
    </div>
@endsection
