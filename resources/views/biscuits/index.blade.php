@extends('layouts.base')
@section('title', 'Biscuits')
@section('content')
<h1 class="mb-3">Biscuits</h1>

<a href="{{ route('biscuits.create') }}" class="btn btn-success mb-3">+ Nouveau biscuit</a>

@if($biscuits->isEmpty())
  <div class="alert alert-info">Aucun biscuit pour l’instant.</div>
@else
  <table class="table table-striped align-middle">
    <thead>
      <tr><th>#</th><th>Nom</th><th>Prix</th><th>Description</th><th class="text-end">Actions</th></tr>
    </thead>
    <tbody>
    @foreach($biscuits as $biscuit)
      <tr>
        <td>{{ $biscuit->id }}</td>
        <td>{{ $biscuit->nom_biscuit }}</td>
        <td>{{ number_format((float)$biscuit->prix, 2) }} $</td>
        <td class="text-truncate" style="max-width: 420px;">{{ $biscuit->description }}</td>
        <td class="text-end">
          <a class="btn btn-sm btn-outline-secondary" href="{{ route('biscuits.edit', $biscuit) }}">Modifier</a>
          <form action="{{ route('biscuits.destroy', $biscuit) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce biscuit ?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger">Supprimer</button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endif
@endsection
