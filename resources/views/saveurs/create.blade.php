<div class="container">
  <h1>Nouvelle saveur</h1>

  <form action="{{ route('saveurs.store') }}" method="post">
    @csrf
    <div>
      <label>Nom *</label>
      <input type="text" name="nom_saveur" value="{{ old('nom_saveur') }}" required>
      @error('nom_saveur') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div>
      <label>Description</label>
      <textarea name="description">{{ old('description') }}</textarea>
    </div>
    <button class="btn btn-success">Enregistrer</button>
    <a class="btn" href="{{ route('saveurs.index') }}">Annuler</a>
  </form>
</div>
