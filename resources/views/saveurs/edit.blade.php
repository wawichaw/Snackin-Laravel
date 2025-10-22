<div class="container">
  <h1>Modifier la saveur #{{ $saveur->id }}</h1>

  <form action="{{ route('saveurs.update', $saveur) }}" method="post">
    @csrf @method('PUT')
    <div>
      <label>Nom *</label>
      <input type="text" name="nom_saveur" value="{{ old('nom_saveur', $saveur->nom_saveur) }}" required>
      @error('nom_saveur') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div>
      <label>Description</label>
      <textarea name="description">{{ old('description', $saveur->description) }}</textarea>
    </div>
    <button class="btn btn-primary">Mettre à jour</button>
    <a class="btn" href="{{ route('saveurs.index') }}">Annuler</a>
  </form>
</div>
