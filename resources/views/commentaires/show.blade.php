<div class="container">
  <h1>{{ __('Commentaire') }} #{{ $commentaire->id }}</h1>

  <ul>
    <li>{{ __('Biscuit') }} : {{ optional($commentaire->biscuit)->nom_biscuit ?? '-' }}</li>
    <li>{{ __('Texte') }} : {{ $commentaire->texte }}</li>
    <li>{{ __('Note') }} : {{ $commentaire->note }}</li>
    <li>{{ __('Utilisateur ID') }} : {{ $commentaire->utilisateur_id }}</li>
  </ul>

  <p><a href="{{ route('commentaires.index') }}">← {{ __('Retour') }}</a></p>
</div>
