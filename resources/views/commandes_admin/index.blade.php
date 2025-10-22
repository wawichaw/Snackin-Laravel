<div class="container">
  <h1>Commandes (admin)</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <p>
    <a class="btn btn-success" href="{{ route('commandes-admin.create') }}">+ Nouvelle commande</a>
  </p>

  <table class="table">
    <thead>
      <tr>
        <th>#</th><th>Client</th><th>Email</th><th>Taille</th><th>Total</th><th>Status</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($commandes as $c)
        <tr>
          <td>{{ $c->id }}</td>
          <td>{{ $c->nom_client }}</td>
          <td>{{ $c->email_client }}</td>
          <td>{{ $c->taille_boite }}</td>
          <td>{{ $c->total_prix }}</td>
          <td>{{ $c->status }}</td>
          <td>
            <a class="btn btn-sm btn-secondary" href="{{ route('commandes-admin.show', $c) }}">Voir</a>
            <a class="btn btn-sm btn-primary" href="{{ route('commandes-admin.edit', $c) }}">Modifier</a>
            <form action="{{ route('commandes-admin.destroy', $c) }}" method="post" style="display:inline-block">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7">Aucune commande.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $commandes->links() }}
</div>
