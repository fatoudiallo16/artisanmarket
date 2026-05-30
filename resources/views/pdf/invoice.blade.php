<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture {{ $numero }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; margin: 40px; }
        h1 { color: #c41e3a; font-size: 22px; margin: 0 0 4px; }
        .brand { font-size: 11px; color: #666; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .text-right { text-align: right; }
        .total-box { margin-top: 20px; text-align: right; font-size: 14px; }
        .total-box strong { color: #c41e3a; font-size: 16px; }
        .meta { margin-bottom: 20px; }
        .meta p { margin: 4px 0; }
    </style>
</head>
<body>
    <h1>ARTISAN MARKET</h1>
    <p class="brand">Facture / Invoice</p>

    <div class="meta">
        <p><strong>N° facture :</strong> {{ $numero }}</p>
        <p><strong>Date de paiement :</strong> {{ $paiement->date_paiement?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}</p>
        <p><strong>Commande :</strong> #{{ $commande->id }}</p>
        <p><strong>Client :</strong> {{ $client->name }} ({{ $client->email }})</p>
        <p><strong>Mode de paiement :</strong> {{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</p>
        <p><strong>Statut :</strong> Payé</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th class="text-right">Qté</th>
                <th class="text-right">Prix unit. (FCFA)</th>
                <th class="text-right">Sous-total (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lignes as $ligne)
                <tr>
                    <td>{{ $ligne->produit?->nom ?? 'Produit #' . $ligne->produit_id }}</td>
                    <td class="text-right">{{ $ligne->quantite }}</td>
                    <td class="text-right">{{ number_format((float) $ligne->prix_unitaire, 0, ',', ' ') }}</td>
                    <td class="text-right">{{ number_format((float) ($ligne->quantite * $ligne->prix_unitaire), 0, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        <p>Total TTC : <strong>{{ number_format((float) $total, 0, ',', ' ') }} FCFA</strong></p>
    </div>

    <p style="margin-top: 40px; font-size: 10px; color: #888;">
        Merci pour votre achat sur Artisan Market. Ce document fait foi de votre paiement enregistré.
    </p>
</body>
</html>
