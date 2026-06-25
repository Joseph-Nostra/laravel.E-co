@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 4rem 0;">
        <div class="glass animate-fade-in" style="width: 100%; max-width: 500px; padding: 3rem; border-radius: 2rem;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Créer un Compte</h1>
                <p style="color: var(--gray-700);">Rejoignez-nous et commencez votre shopping.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" style="display: grid; gap: 1.25rem;">
                @csrf
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Nom Complet</label>
                    <input type="text" name="name" required style="width: 100%; padding: 0.875rem 1rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;" value="{{ old('name') }}">
                    @error('name') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">E-mail</label>
                    <input type="email" name="email" required style="width: 100%; padding: 0.875rem 1rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;" value="{{ old('email') }}">
                    @error('email') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Mot de Passe</label>
                    <input type="password" name="password" required style="width: 100%; padding: 0.875rem 1rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;">
                    @error('password') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Confirmer le Mot de Passe</label>
                    <input type="password" name="password_confirmation" required style="width: 100%; padding: 0.875rem 1rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;">
                </div>

                <div style="display: flex; align-items: start; gap: 0.5rem; margin-top: 0.5rem;">
                    <input type="checkbox" id="terms" required style="margin-top: 4px; width: 16px; height: 16px; accent-color: var(--primary);">
                    <label for="terms" style="font-size: 0.875rem; color: var(--gray-700);">J'accepte les conditions générales et la politique de confidentialité.</label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; margin-top: 1rem; font-size: 1.125rem;">Créer mon Compte</button>
            </form>

            <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--gray-100);">
                <p style="color: var(--gray-700);">Déjà inscrit ? <a href="{{ route('login') }}" style="color: var(--primary); font-weight: 700;">Se connecter</a></p>
            </div>
        </div>
    </div>
@endsection
