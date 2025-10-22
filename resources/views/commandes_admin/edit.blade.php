<div class="container">
  <h1>Modifier commande #{{ $commande->id }}</h1>

  <form method="post" action="{{ route('commandes-admin.update', $commande) }}">
    @csrf @method('PUT')

    <div>
      <label>Taille de boîte *</label>
      <select name="taille_boite" required>
        @foreach([4,6,12] as $t)
          <option value="{{ $t }}" @selected(old('taille_boite',$commande->taille_boite)==$t)>{{ $t }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label>Nom client *</label>
      <input type="text" name="nom_client" value="{{ old('nom_client',$commande->nom_client) }}" required>
    </div>

    <div>
      <label>Email client *</label>
      <input type="email" name="email_client" value="{{ old('email_client',$commande->email_client) }}" required>
    </div>

    <div>
      <label>Total (optionnel)</label>
      <input type="number" step="0.01" name="total_prix" value="{{ old('total_prix',$commande->total_prix) }}">
    </div>

    <div>
      <label>Détails (JSON optionnel)</label>
      <textarea name="details">{{ old('details', json_encode($commande->details)) }}</textarea>
    </div>

    <div>
      <label>Status</label>
      <input type="text" name="status" value="{{ old('status',$commande->status) }}">
    </div>

    <button class="btn btn-primary">Mettre à jour</button>
    <a class="btn" href="{{ route('commandes-admin.index') }}">Annuler</a>
  </form>
</div>
