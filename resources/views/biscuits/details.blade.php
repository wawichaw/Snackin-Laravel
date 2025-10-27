<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Biscuits</title>
</head>
<body>
    <title>Détails du Biscuit</title>
    <h2>{{ $biscuit->nom_biscuit }}</h2>
    <p><strong>Saveur:</strong> {{ $biscuit->nom_saveur }}</p>
    <p><strong>Description:</strong> {{ $biscuit->description }}</p>
    <p><strong>Prix:</strong> {{ $biscuit->prix }} €</p>
    @if($biscuit->image)
        <img src="{{ asset('storage/' . $biscuit->image) }}" alt="{{ $biscuit->nom_biscuit }}" alt="Image du biscuit" style="max-width:300px;">
    @endif
</body>
</html>