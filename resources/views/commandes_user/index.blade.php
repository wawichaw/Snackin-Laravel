@extends('layouts.app')

@section('content')
<div class="container py-5">
  <h1>Mes commandes</h1>

  @if($commandes->isEmpty())
    <div class="alert alert-info">Vous n'avez aucune commande.</div>
  @else
    <ul class="list-group">
      @foreach($commandes as $c)
        <li class="list-group-item">
          <strong>#{{ $c->id }}</strong> — {{ $c->created_at->format('Y-m-d H:i') }}
          <div>
            <small>Taille: {{ optional($c->details_json)['taille'] ?? optional($c->details)['taille'] ?? '—' }}</small>
          </div>
        </li>
      @endforeach
    </ul>
  @endif
</div>
@endsection