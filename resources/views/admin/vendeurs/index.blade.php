@extends('layouts.admin')

@section('title', 'Modération des Vendeurs - Admin')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Modération des Vendeurs
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Gérez les comptes des artisans, approuvez les nouvelles demandes ou suspendez des boutiques.
            </p>
        </div>
        <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-4 py-2 rounded-xl">
            Total : {{ $vendeurs->total() }} vendeur(s)
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3">
            <span>✅</span>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Vendors Table Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if($vendeurs->count() > 0)
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-semibold text-slate-400 uppercase bg-slate-50/50">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Artisan</th>
                            <th class="px-6 py-4">Nom Boutique</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Date Demande</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @foreach($vendeurs as $vendeur)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-slate-400">
                                    #{{ $vendeur->id }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $vendeur->name }}
                                </td>
                                <td class="px-6 py-4 italic text-slate-700">
                                    {{ $vendeur->nom_boutique }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $vendeur->user->email ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClass = match($vendeur->statut->value) {
                                            'approuve' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                            'en_attente' => 'bg-amber-100 text-amber-800 border-amber-200',
                                            'suspendu' => 'bg-slate-100 text-slate-800 border-slate-200',
                                            'rejete' => 'bg-rose-100 text-rose-800 border-rose-200',
                                            default => 'bg-slate-100 text-slate-800 border-slate-200',
                                        };
                                        $statusLabel = match($vendeur->statut->value) {
                                            'approuve' => 'Approuvé',
                                            'en_attente' => 'En attente',
                                            'suspendu' => 'Suspendu',
                                            'rejete' => 'Rejeté',
                                            default => $vendeur->statut->value,
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-400">
                                    {{ $vendeur->created_at ? $vendeur->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @if($vendeur->statut->value === 'en_attente')
                                            <form action="{{ route('admin.vendeurs.update', $vendeur) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="approuve">
                                                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-500 hover:bg-emerald-600 text-white transition">
                                                    Approuver
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.vendeurs.update', $vendeur) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="rejete">
                                                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-rose-500 hover:bg-rose-600 text-white transition">
                                                    Rejeter
                                                </button>
                                            </form>
                                        @elseif($vendeur->statut->value === 'approuve')
                                            <form action="{{ route('admin.vendeurs.update', $vendeur) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="suspendu">
                                                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-500 hover:bg-slate-600 text-white transition">
                                                    Suspendre
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.vendeurs.update', $vendeur) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="statut" value="approuve">
                                                <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-500 hover:bg-amber-600 text-white transition">
                                                    Réactiver
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-12 text-center text-slate-400">
                    Aucun vendeur trouvé.
                </div>
            @endif
        </div>

        <!-- Pagination Footer -->
        @if($vendeurs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $vendeurs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
