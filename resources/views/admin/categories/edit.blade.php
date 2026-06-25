@extends('layouts.admin')

@section('title', 'Modifier la Catégorie')

@section('content')
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.categories.index') }}" class="btn" style="background: var(--gray-200); color: var(--dark);">
            <i class="fa-solid fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="glass" style="padding: 2rem; border-radius: 1rem; max-width: 500px;">
        <h3 style="margin-bottom: 2rem;">Détails de la Catégorie : {{ $category->name }}</h3>
        
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" style="display: grid; gap: 1.5rem;">
            @csrf
            @method('PUT')
            
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Nom de la catégorie</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
            </div>
            
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Description</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--gray-200);">{{ old('description', $category->description) }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%;">Mettre à jour</button>
        </form>
    </div>
@endsection
