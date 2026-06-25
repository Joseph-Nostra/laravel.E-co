@extends('layouts.admin')

@section('title', 'Gestion des Produits')

@section('content')
    <div style="margin-bottom: 2rem; display: flex; justify-content: flex-end;">
        <button id="add-product-btn" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Nouveau Produit
        </button>
    </div>

    <!-- Add Product Modal (simulated for simplicity) -->
    <div id="add-product-panel" class="glass" style="display: none; padding: 2rem; border-radius: 1rem; margin-bottom: 3rem;">
        <h3 style="margin-bottom: 2rem;">Ajouter un Produit</h3>
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            @csrf
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nom</label>
                <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Catégorie</label>
                <select name="category_id" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Prix (DH)</label>
                <input type="number" step="0.01" name="price" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Stock</label>
                <input type="number" name="stock" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
            </div>
            <div style="grid-column: span 2;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Description</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);"></textarea>
            </div>
            <div style="grid-column: span 2;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Images</label>
                <input type="file" name="images[]" multiple style="width: 100%;">
            </div>
            <div style="grid-column: span 2; display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="document.getElementById('add-product-panel').style.display='none'" class="btn" style="background: var(--gray-200); color: var(--dark);">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer le Produit</button>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="glass" style="padding: 2rem; border-radius: 1rem;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 1px solid var(--gray-200); color: var(--gray-700);">
                    <th style="padding: 1rem;">Produit</th>
                    <th style="padding: 1rem;">Catégorie</th>
                    <th style="padding: 1rem;">Prix</th>
                    <th style="padding: 1rem;">Stock</th>
                    <th style="padding: 1rem;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr style="border-bottom: 1px solid var(--gray-100);">
                        <td style="padding: 1rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <img src="{{ $product->images->first()->image ?? 'https://via.placeholder.com/50' }}" style="width: 40px; height: 40px; border-radius: 0.25rem; object-fit: cover;">
                                <span style="font-weight: 600;">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td style="padding: 1rem;">{{ $product->category->name }}</td>
                        <td style="padding: 1rem; font-weight: 700;">{{ number_format($product->price, 2) }} DH</td>
                        <td style="padding: 1rem;">
                            <span style="font-weight: 600; {{ $product->stock < 10 ? 'color: #ef4444;' : '' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 1rem;">
                                <button style="color: var(--primary); background: none; border: none; cursor: pointer;"><i class="fa-solid fa-pen"></i></button>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 2rem;">
            {{ $products->links() }}
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.getElementById('add-product-btn').addEventListener('click', () => {
        const panel = document.getElementById('add-product-panel');
        panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        if(panel.style.display === 'block') panel.scrollIntoView({ behavior: 'smooth' });
    });
</script>
@endsection
