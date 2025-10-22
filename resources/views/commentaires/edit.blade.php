<div class="container">
  <h1>Modifier commentaire #{{ $commentaire->id }}</h1>

  <form method="post" action="{{ route('commentaires.update', $commentaire) }}">
    @csrf @method('PUT')

    <div>
      <label>Biscuit *</label>
      <select name="biscuit_id" required>
        @foreach($biscuits as $b)
          <option value="{{ $b->id }}" @selected(old('biscuit_id',$commentaire->biscuit_id)==$b->id)>{{ $b->nom_biscuit }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label>Texte *</label>
      <textarea name="texte" required>{{ old('texte',$commentaire->texte) }}</textarea>
    </div>

    <div>
      <label>Note (1-5)</label>
      <input type="number" name="note" min="1" max="5" value="{{ old('note',$commentaire->note) }}">
    </div>

    <div>
      <label>Utilisateur ID (optionnel)</label>
      <input type="number" name="utilisateur_id" value="{{ old('utilisateur_id',$commentaire->utilisateur_id) }}">
    </div>

    <button class="btn btn-primary">Mettre à jour</button>
    <a class="btn" href="{{ route('commentaires.index') }}">Annuler</a>
  </form>
</div>
