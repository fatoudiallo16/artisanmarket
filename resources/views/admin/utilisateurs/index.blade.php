@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs - Admin')

@section('content')
<div class="space-y-6 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Gestion des Utilisateurs
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Visualisez et suivez tous les comptes enregistrés sur Artisan Market.
            </p>
        </div>
        <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-4 py-2 rounded-xl">
            Total : {{ $users->total() }} utilisateur(s)
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            @if($users->count() > 0)
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-semibold text-slate-400 uppercase bg-slate-50/50">
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Nom Complet</th>
                            <th class="px-6 py-4">Adresse E-mail</th>
                            <th class="px-6 py-4">Rôle</th>
                            <th class="px-6 py-4">Date d'inscription</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-mono font-bold text-slate-400">
                                    #{{ $user->id }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $roleName = $user->role ? $user->role->nom_role : 'client';
                                        $roleClass = match($roleName) {
                                            'admin' => 'bg-amber-100 text-amber-800 border-amber-200',
                                            'vendeur' => 'bg-purple-100 text-purple-800 border-purple-200',
                                            default => 'bg-blue-100 text-blue-800 border-blue-200',
                                        };
                                        $roleLabel = match($roleName) {
                                            'admin' => 'Administrateur',
                                            'vendeur' => 'Vendeur',
                                            default => 'Client',
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $roleClass }}">
                                        {{ $roleLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-slate-400">
                                    {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-12 text-center text-slate-400">
                    Aucun utilisateur trouvé.
                </div>
            @endif
        </div>

        <!-- Pagination Footer -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
