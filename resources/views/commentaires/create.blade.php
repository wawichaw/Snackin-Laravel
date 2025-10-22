<div class="container">
  <h1>Nouveau commentaire</h1>

  <form method="post" action="{{ route('commentaires.store') }}">
    @csrf

    <div>
      <label>Biscuit *</label>
      <select name="biscuit_id" required>
        <option value="">-- choisir --</option>
        @foreach($biscuits as $b)
          <option value="{{ $b->id }}" @selected(old('biscuit_id')==$b->id)>{{ $b->nom_biscuit }}</option>
        @endforeach
      </select>
      @error('biscuit_id') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div>
      <label>Texte *</label>
      <textarea name="texte" required>{{ old('texte') }}</textarea>
      @error('texte') <div class="text-danger">{{ $message }}</div> @enderror
    </div>

    <div>
      <label>Note (1-5)</label>
      <input type="number" name="note" min="1" max="5" value="{{ old('note') }}">
    </div>

    <div>
      <label>Utilisateur ID (optionnel)</label>
      <input type="number" name="utilisateur_id" value="{{ old('utilisateur_id') }}">
    </div>

    <button class="btn btn-success">Créer</button>
    <a class="btn" href="{{ route('commentaires.index') }}">Annuler</a>
  </form>
</div>
