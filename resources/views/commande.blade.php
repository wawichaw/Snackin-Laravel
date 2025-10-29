@extends('layouts.app')
@section('title', {{ __('Commander des boîtes') }})

@section('content')
<link rel="stylesheet" href="{{ asset('Contenu/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/landing.css') }}">
<link rel="stylesheet" href="{{ asset('Contenu/css/commande.css') }}">
{{-- NAV / HEADER — identique à accueil/index --}}
<div class="snk-nav">
  <div class="snk-container">
    <a class="snk-logo" href="{{ route('home') }}">
      <img src="{{ asset('Contenu/img/snackin-logo.png') }}" alt="{{ __('Snackin logo') }}" style="width:36px;height:36px;object-fit:contain">
      <strong>{{ __('Snackin\'') }}</strong>
    </a>
    <span class="snk-badge">{{ __('Fait à Montréal')}}</span>

    <div class="snk-spacer"></div>
    <a href="{{ route('home') }}">{{ __('Accueil')}}</a>
    <a href="{{ route('biscuits.index') }}">{{ __('Biscuits')}}</a>
    <a href="{{ route('commandes.create') }}" aria-current="page">{{ __('Commander')}}</a>
    @auth
      @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
        <a href="{{ route('saveurs.index') }}">{{ __('Saveurs')}}</a>
      @endif
    @endauth
    <a href="{{ route('about') }}">{{ __('À propos')}}</a>

    <div class="snk-spacer"></div>
    @auth
      @if(Auth::user()->is_admin || Auth::user()->role === 'ADMIN')
        <span class="snk-greeting" style="color: #000; font-weight: bold; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">{{ __('Bonjour Admin,') }} {{ Auth::user()->name }}</span>
      @else
        <span class="snk-greeting" style="color: #000; font-weight: bold; background: rgba(255,255,255,0.9); padding: 4px 8px; border-radius: 4px;">{{ __('Bonjour,') }} {{ Auth::user()->name }}</span>
      @endif
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Se déconnecter')}}</a>
      </form>
    @else
      <a href="{{ route('login') }}" style="margin-right:10px;">{{ __('Se connecter')}}</a>
      @if (Route::has('register')) <a href="{{ route('register') }}">{{ __('S’inscrire')}}</a> @endif
    @endauth
  </div>
</div>

{{-- HERO avec tes photos + bonshommes sourire rouges qui flottent --}}
<section class="commande-hero">
  <div class="hero-grid">
    <img src="{{ asset('Contenu/img/commande-1.png') }}" alt="{{ __('Boîte de biscuits 1') }}">
    <img src="{{ asset('Contenu/img/commande-2.png') }}" alt="{{ __('Boîte de biscuits 2') }}">
    <img src="{{ asset('Contenu/img/commande-3.png') }}" alt="{{ __('Boîte de biscuits 3') }}">
    <img src="{{ asset('Contenu/img/commande-4.png') }}" alt="{{ __('Préparation de biscuits') }}">
  </div>

  <!-- Smiles flottants -->
  <div class="smile s1">{{ __('😊') }}</div>
  <div class="smile s2">{{ __('😊') }}</div>
  <div class="smile s3">{{ __('😊') }}</div>
</section>

<div class="commande-container container">
  <h1>{{ __('Commander des boîtes de biscuits')}}</h1>

  @if (session('message_succes'))
    <div class="alert alert-success">{{ session('message_succes') }}</div>
  @endif
  @if (session('ok'))
    <div class="alert alert-success">{{ __('Votre commande a été enregistrée. Merci !')}}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="commande-form">
    <form method="POST" action="{{ route('commandes.store') }}">
      @csrf

      {{-- TAILLE DE BOÎTE --}}
      <div class="form-section">
        <h2>{{ __('Choisissez la taille de votre boîte')}}</h2>
        <div class="boite-options">
          <label class="boite-option">
            <input type="radio" name="taille_boite" value="4" required>
          <div class="boite-card">
              <div class="boite-icon">{{ __('🧁') }}</div>
              <h3>{{ __('Boîte de 4') }}</h3>
              <p>{{ __('Parfait pour une dégustation') }}</p>
              <span class="prix">15 {{ __('$') }}</span>
            </div>
          </label>

          <label class="boite-option">
            <input type="radio" name="taille_boite" value="6" required>
          <div class="boite-card">
              <div class="boite-icon">{{ __('🍪') }}</div>
              <h3>{{ __('Boîte de 6') }}</h3>
              <p>{{ __('Idéal pour partager') }}</p>
              <span class="prix">20 {{ __('$') }}</span>
            </div>
          </label>

          <label class="boite-option">
            <input type="radio" name="taille_boite" value="12" required>
          <div class="boite-card">
              <div class="boite-icon">{{ __('🎁') }}</div>
              <h3>{{ __('Boîte de 12') }}</h3>
              <p>{{ __('Pour les gourmands') }}</p>
              <span class="prix">35 {{ __('$') }}</span>
            </div>
          </label>
        </div>
      </div>

      {{-- SAVEURS + QUANTITÉS --}}
      <div class="form-section">
        <h2>{{ __('Choisissez vos saveurs et quantités')}}</h2>
        <p class="info-text">
          {{ __('Sélectionnez les saveurs et indiquez la quantité pour chaque biscuit.
          Le total doit correspondre à la taille de boîte choisie.')}}
        </p>

        <div class="saveurs-grid">
          @foreach ($biscuits as $biscuit)
            <div class="saveur-item">
              <div class="saveur-card">
                <div class="saveur-top">
                  <h4>{{ $biscuit->nom_biscuit ?? $biscuit->nom }}</h4>
                  <span class="prix-biscuit">{{ number_format($biscuit->prix, 2) }} $</span>
                </div>
                <div class="quantite-control">
                  <label>{{ __'Quantité'}}</label>
                  <div class="qty-row">
                    <button type="button" class="qty-btn minus" aria-label="Retirer 1">−</button>
                    <input
                      type="number"
                      name="quantites[{{ $biscuit->id }}]"
                      min="0" max="12" value="0"
                      class="quantite-input"
                      data-biscuit-id="{{ $biscuit->id }}"
                      data-biscuit-nom="{{ $biscuit->nom_biscuit ?? $biscuit->nom }}"
                    >
                    <button type="button" class="qty-btn plus" aria-label="{{ __('Ajouter 1') }}">+</button>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="total-info">
          <p>{{ __('Total sélectionné') }} :
            <span id="total-selectionne">0</span> /
            <span id="taille-max">0</span> {{ __('biscuits') }}
          </p>
          <p style="font-size: 18px; font-weight: bold; color: #2a1620; margin-top: 10px;">
            {{ __('Prix total') }} : <span id="prix-total">0$</span>
          </p>
        </div>
      </div>

      {{-- INFOS CLIENT --}}
      <div class="form-section">
        <h2>{{ __('Vos informations') }}</h2>
        <div class="form-row">
          <label>
            {{ __('Nom complet') }}
            <input type="text" name="nom_client" required value="{{ old('nom_client') }}">
          </label>

          <label>
            {{ __('Email') }}
            <input type="email" name="email_client" required value="{{ old('email_client') }}">
          </label>
        </div>
      </div>

      {{-- CTA --}}
      <div class="form-actions">
        <button type="submit" class="btn btn-success btn-large">
          {{ __('Passer la commande') }}
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

{{-- JS de validation & interactions --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const tailleInputs  = document.querySelectorAll('input[name="taille_boite"]');
  const quantiteInputs = document.querySelectorAll('.quantite-input');
  const totalSpan     = document.getElementById('total-selectionne');
  const tailleMaxSpan = document.getElementById('taille-max');
  const prixTotalSpan = document.getElementById('prix-total');

  // Prix par taille de boîte
  const prixParTaille = {
    '4': 15.00,
    '6': 20.00,
    '12': 35.00
  };

  function getTailleMax() {
    const checked = document.querySelector('input[name="taille_boite"]:checked');
    return checked ? parseInt(checked.value) : 0;
  }

  function updateTotal() {
    let total = 0;
    quantiteInputs.forEach(input => total += parseInt(input.value) || 0);
    totalSpan.textContent = total;

    const max = getTailleMax();
    tailleMaxSpan.textContent = max;

    // Mettre à jour le prix total
    const tailleBoite = document.querySelector('input[name="taille_boite"]:checked');
    if (tailleBoite && prixParTaille[tailleBoite.value]) {
      prixTotalSpan.textContent = prixParTaille[tailleBoite.value] + '$';
    } else {
      prixTotalSpan.textContent = '0$';
    }

    if (!max) { 
      totalSpan.style.color = ''; 
      return; 
    }

    if (total === max) {
      totalSpan.style.color = 'var(--ok)';
    } else if (total > max) {
      totalSpan.style.color = 'var(--danger)';
    } else {
      totalSpan.style.color = 'var(--warn)';
    }
  }

  // Radio taille : reset quantités + maj limites
  tailleInputs.forEach(input => {
    input.addEventListener('change', () => {
      const max = getTailleMax();
      quantiteInputs.forEach(q => { q.value = 0; q.max = max; });
      updateTotal();
    });
  });

  // + / - boutons
  document.querySelectorAll('.qty-btn.plus').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.parentElement.querySelector('.quantite-input');
      const max = getTailleMax();
      const total = [...quantiteInputs].reduce((s,i)=>s+(parseInt(i.value)||0),0);
      if (max && total < max) input.value = Math.min(max, (parseInt(input.value)||0) + 1);
      updateTotal();
    });
  });

  document.querySelectorAll('.qty-btn.minus').forEach(btn => {
    btn.addEventListener('click', () => {
      const input = btn.parentElement.querySelector('.quantite-input');
      input.value = Math.max(0, (parseInt(input.value)||0) - 1);
      updateTotal();
    });
  });

  // Input direct
  quantiteInputs.forEach(input => {
    input.addEventListener('input', () => {
      const max = getTailleMax();
      if (max) {
        // borne locale
        input.value = Math.max(0, Math.min(max, parseInt(input.value)||0));
        // borne globale
        const total = [...quantiteInputs].reduce((s,i)=>s+(parseInt(i.value)||0),0);
        if (total > max) {
          const diff = total - max;
          input.value = Math.max(0, (parseInt(input.value)||0) - diff);
        }
      } else {
        input.value = Math.max(0, parseInt(input.value)||0);
      }
      updateTotal();
    });
  });

  updateTotal();
});
</script>
