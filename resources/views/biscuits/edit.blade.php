@extends('layouts.base')
@section('title', 'Modifier biscuit')
@section('content')
<h1 class="mb-3">Modifier: {{ $biscuit->nom_biscuit }}</h1>

@if ($errors->any())
  <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
@endif

<form action="{{ route('biscuits.update', $biscuit) }}" method="POST" class="card p-3">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="nom_biscuit" class="form-control" value="{{ old('nom_biscuit', $biscuit->nom_biscuit) }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Prix</label>
    <input type="number" step="0.01" name="prix" class="form-control" value="{{ old('prix', $biscuit->prix) }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="3">{{ old('description', $biscuit->description) }}</textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Image (URL)</label>
    <input type="text" name="image" class="form-control" value="{{ old('image', $biscuit->image) }}">
  </div>
  <div class="d-flex gap-2">
    <button class="btn btn-primary">Mettre à jour</button>
    <a class="btn btn-outline-secondary" href="{{ route('biscuits.index') }}">Annuler</a>
  </div>
</form>
@endsection
