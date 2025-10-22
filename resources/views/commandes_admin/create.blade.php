<div class="container">
  <h1>Nouvelle commande (admin)</h1>

  <form method="post" action="{{ route('commandes-admin.store') }}">
    @csrf

    <div>
      <label>Taille de boîte *</label>
      <select name="taille_boite" required>
        @foreach([4,6,12] as $t)
          <option value="{{ $t }}" @selected(old('taille_boite')==$t)>{{ $t }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label>Nom client *</label>
      <input type="text" name="nom_client" value="{{ old('nom_client') }}" required>
    </div>

    <div>
      <label>Email client *</label>
      <input type="email" name="email_client" value="{{ old('email_client') }}" required>
    </div>

    <div>
      <label>Total (optionnel)</label>
      <input type="number" step="0.01" name="total_prix" value="{{ old('total_prix') }}">
    </div>

    <div>
      <label>Détails (JSON optionnel)</label>
      <textarea name="details" placeholder='{"1":2,"5":1}'>{{ old('details') }}</textarea>
      <small>Peut rester vide.</small>
    </div>

    <div>
      <label>Status</label>
      <input type="text" name="status" value="{{ old('status','en_attente') }}">
    </div>

    <button class="btn btn-success">Créer</button>
    <a class="btn" href="{{ route('commandes-admin.index') }}">Annuler</a>
  </form>
</div>
