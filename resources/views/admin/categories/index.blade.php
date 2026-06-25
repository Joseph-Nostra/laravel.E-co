@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('content')
    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem; align-items: start;">
        <div class="glass" style="padding: 2rem; border-radius: 1rem;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 1px solid var(--gray-200); color: var(--gray-700);">
                        <th style="padding: 1rem;">ID</th>
                        <th style="padding: 1rem;">Nom</th>
                        <th style="padding: 1rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr style="border-bottom: 1px solid var(--gray-100);">
                            <td style="padding: 1rem;">{{ $category->id }}</td>
                            <td style="padding: 1rem; font-weight: 700;">{{ $category->name }}</td>
                            <td style="padding: 1rem;">
                                <div style="display: flex; gap: 1rem;">
                                    <button class="edit-btn" style="color: var(--primary); background: none; border: none; cursor: pointer;">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <aside class="glass" style="padding: 2rem; border-radius: 1rem;">
            <h3 style="font-size: 1.125rem; font-weight: 800; margin-bottom: 1.5rem;">Nouvelle Catégorie</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST" style="display: grid; gap: 1rem;">
                @csrf
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.4rem;">Nom de la catégorie</label>
                    <input type="text" name="name" required style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid var(--gray-200); outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.4rem;">Description (optionnel)</label>
                    <textarea name="description" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; border: 1px solid var(--gray-200); outline: none;" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Ajouter</button>
            </form>
        </aside>
    </div>
@endsection
