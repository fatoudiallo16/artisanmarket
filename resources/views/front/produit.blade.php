<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Fiche Produit</h1>
    <p>Nom: {{ $produit->name }}</p>
    <p>Description: {{ $produit->description }}</p>
    <p>Prix: {{ $produit->price }} fcfa</p>
    <!-- Ajoutez d'autres informations du produit selon vos besoins -->
</body>
</html>