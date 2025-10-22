<div class="container">
  <h1>Saveurs</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <p><a class="btn btn-success" href="{{ route('saveurs.create') }}">+ Ajouter une saveur</a></p>

  <table class="table">
    <thead>
      <tr>
        <th>#</th><th>Nom</th><th>Description</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @forelse($saveurs as $s)
        <tr>
          <td>{{ $s->id }}</td>
          <td><a href="{{ route('saveurs.show', $s) }}">{{ $s->nom_saveur }}</a></td>
          <td>{{ $s->description }}</td>
          <td>
            <a class="btn btn-sm btn-primary" href="{{ route('saveurs.edit', $s) }}">Modifier</a>
            <form action="{{ route('saveurs.destroy', $s) }}" method="post" style="display:inline-block">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ?')">Supprimer</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="4">Aucune saveur.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
