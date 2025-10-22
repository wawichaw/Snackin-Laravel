<div class="container">
  <h1>Commentaire #{{ $commentaire->id }}</h1>

  <ul>
    <li>Biscuit : {{ optional($commentaire->biscuit)->nom_biscuit ?? '-' }}</li>
    <li>Texte : {{ $commentaire->texte }}</li>
    <li>Note : {{ $commentaire->note }}</li>
    <li>Utilisateur ID : {{ $commentaire->utilisateur_id }}</li>
  </ul>

  <p><a href="{{ route('commentaires.index') }}">← Retour</a></p>
</div>
