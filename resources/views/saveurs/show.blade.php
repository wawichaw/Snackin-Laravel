<div class="container">
  <h1>Saveur: {{ $saveur->nom_saveur }}</h1>
  <p>{{ $saveur->description }}</p>
  <p><a href="{{ route('saveurs.index') }}">← Retour</a></p>
</div>
