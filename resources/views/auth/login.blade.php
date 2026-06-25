@extends('layouts.app')

@section('content')
    <div class="container" style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 4rem 0;">
        <div class="glass animate-fade-in" style="width: 100%; max-width: 450px; padding: 3rem; border-radius: 2rem;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Bon Retour !</h1>
                <p style="color: var(--gray-700);">Connectez-vous pour accéder à votre compte.</p>
            </div>

            <form action="{{ route('login') }}" method="POST" style="display: grid; gap: 1.5rem;">
                @csrf
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">E-mail</label>
                    <input type="email" name="email" required style="width: 100%; padding: 0.875rem 1rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;" value="{{ old('email') }}">
                    @error('email') <p style="color: #ef4444; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <label style="font-weight: 600;">Mot de Passe</label>
                        <a href="#" style="font-size: 0.75rem; color: var(--primary);">Mot de passe oublié ?</a>
                    </div>
                    <input type="password" name="password" required style="width: 100%; padding: 0.875rem 1rem; border-radius: 0.75rem; border: 1px solid var(--gray-200); outline: none;">
                </div>
                
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                    <input type="checkbox" id="remember" name="remember" style="width: 16px; height: 16px; accent-color: var(--primary);">
                    <label for="remember" style="font-size: 0.875rem; color: var(--gray-700);">Se souvenir de moi</label>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem; margin-top: 1rem; font-size: 1.125rem;">Connexion</button>
            </form>

            <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--gray-100);">
                <p style="color: var(--gray-700);">Pas encore de compte ? <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 700;">S'inscrire</a></p>
            </div>
        </div>
    </div>
@endsection
