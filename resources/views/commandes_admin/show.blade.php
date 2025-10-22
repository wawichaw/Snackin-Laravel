<div class="container">
  <h1>Commande #{{ $commande->id }}</h1>

  <ul>
    <li>Client : {{ $commande->nom_client }} ({{ $commande->email_client }})</li>
    <li>Taille boîte : {{ $commande->taille_boite }}</li>
    <li>Total : {{ $commande->total_prix }}</li>
    <li>Status : {{ $commande->status }}</li>
    <li>Détails : <pre>{{ json_encode($commande->details, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre></li>
  </ul>

  <p><a href="{{ route('commandes-admin.index') }}">← Retour</a></p>
</div>
