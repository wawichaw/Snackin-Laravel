@extends('layouts.base')

@section('title', 'Inscription')

@section('content')
<div style="max-width: 500px; margin: 50px auto; padding: 20px;">
    <h2 style="text-align: center; margin-bottom: 30px;">S'inscrire</h2>

    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom: 20px;">
            <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Nom</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
            @error('name')
                <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
            @error('email')
                <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password" style="display: block; margin-bottom: 5px; font-weight: bold;">Mot de passe</label>
            <input id="password" type="password" name="password" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
            @error('password')
                <span style="color: #dc3545; font-size: 14px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 20px;">
            <label for="password-confirm" style="display: block; margin-bottom: 5px; font-weight: bold;">Confirmer le mot de passe</label>
            <input id="password-confirm" type="password" name="password_confirmation" required 
                   style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px;">
        </div>

        <div style="text-align: center;">
            <button type="submit" style="background: #9b182b; color: white; padding: 12px 40px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
                S'inscrire
            </button>
            
            <div style="margin-top: 20px;">
                <a href="{{ route('login') }}" style="color: #9b182b; text-decoration: none;">
                    Déjà un compte ? Se connecter
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
