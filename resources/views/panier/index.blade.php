@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Mon panier</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($articles->isEmpty())
        <div class="alert alert-info">Votre panier est vide.</div>
    @else
        @php $total = 0; @endphp

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Quantite</th>
                        <th>Sous-total</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        @php
                            $sousTotal = (float) $article->prix_unitaire * (int) $article->quantite;
                            $total += $sousTotal;
                        @endphp
                        <tr>
                            <td>{{ $article->produit->nom ?? 'Produit indisponible' }}</td>
                            <td>{{ number_format((float) $article->prix_unitaire, 2, ',', ' ') }} MAD</td>
                            <td style="max-width: 170px;">
                                @if ($article->produit)
                                    <form method="POST" action="{{ route('panier.update', $article->produit) }}" class="d-flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantite" min="1" max="100" value="{{ $article->quantite }}" class="form-control form-control-sm">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">OK</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ number_format($sousTotal, 2, ',', ' ') }} MAD</td>
                            <td class="text-end">
                                @if ($article->produit)
                                    <form method="POST" action="{{ route('panier.destroy', $article->produit) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <h4 class="mb-0">Total: {{ number_format($total, 2, ',', ' ') }} MAD</h4>
            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('panier.clear') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-secondary">Vider le panier</button>
                </form>
                <form method="POST" action="{{ route('panier.checkout') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Valider la commande</button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
