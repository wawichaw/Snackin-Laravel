<div class="container">
  <h1>Commentaires</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <p><a class="btn btn-success" href="{{ route('commentaires.create') }}">+ Nouveau commentaire</a></p>

  <table class="table">
    <thead>
      <tr>
        <th>#</th><th>Biscuit</th><th>Texte</th><th>Note</th><th>Utilisateur</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($commentaires as $c)
        <tr>
          <td>{{ $c->id }}</td>
          <td>{{ optional($c->biscuit)->nom_biscuit ?? '-' }}</td>
          <td>{{ Str::limit($c->texte, 80) }}</td>
          <td>{{ $c->note }}</td>
          <td>{{ $c->utilisateur_id }}</td>
          <td>
            <a class="btn btn-sm btn-secondary" href="{{ route('commentaires.show', $c) }}">Voir</a>
            <a class="btn btn-sm btn-primary" href="{{ route('commentaires.edit', $c) }}">Modifier</a>
            <form action="{{ route('commentaires.destroy', $c) }}" method="post" style="display:inline-block">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">Aucun commentaire.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $commentaires->links() }}
</div>
