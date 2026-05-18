<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

class PaiementController extends Controller
{
    public function __construct(private PaymentService $paymentService)
    {
    }
    public function index(): View
    {
        $this->authorize('viewAny', Paiement::class);

        /** @var User|null $user */
        $user = Auth::user();
        $query = Paiement::with('commande')->latest();
        if ($user && !$user->hasRole('admin')) {
            $query->whereHas('commande', function ($q): void {
                $q->where('user_id', Auth::id());
            });
        }

        $paiements = $query->paginate(15);

        return view('paiements.index', compact('paiements'));
    }

    public function show(Paiement $paiement): View
    {
        $this->authorize('view', $paiement);

        return view('paiements.show', compact('paiement'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Paiement::class);

        $data = $request->validate([
            'commande_id' => ['required', 'exists:commandes,id'],
            'montant' => ['required', 'numeric', 'min:0.01'],
            'mode_paiement' => ['required', 'string', 'max:100'],
            'statut' => ['nullable', 'in:en_attente,paye,echoue,rembourse'],
        ]);

        $commande = Commande::findOrFail((int) $data['commande_id']);
        /** @var User|null $user */
        $user = Auth::user();
        if ($user && !$user->hasRole('admin') && (int) $commande->user_id !== (int) Auth::id()) {
            abort(403, 'Commande non autorisée pour ce paiement.');
        }

        $paiement = $this->paymentService->createPayment(
            $commande->id,
            $data['montant'],
            $data['mode_paiement']
        );

        return redirect()->route($this->routeName('show'), $paiement)->with('success', 'Paiement enregistré.');
    }

    public function update(Request $request, Paiement $paiement): RedirectResponse
    {
        $this->authorize('update', $paiement);

        $data = $request->validate([
            'statut' => ['required', 'in:en_attente,paye,echoue,rembourse'],
            'mode_paiement' => ['nullable', 'string', 'max:100'],
        ]);

        if ($data['statut'] === 'paye') {
            $this->paymentService->markAsPaid($paiement);
        } elseif ($data['statut'] === 'rembourse') {
            $this->paymentService->refundPayment($paiement);
        } elseif ($data['statut'] === 'echoue') {
            $this->paymentService->markAsFailed($paiement);
        } else {
            $paiement->update($data);
        }

        return redirect()->route($this->routeName('show'), $paiement)->with('success', 'Paiement mis à jour.');
    }

    public function destroy(Paiement $paiement): RedirectResponse
    {
        $this->authorize('delete', $paiement);

        $paiement->delete();

        return redirect()->route($this->routeName('index'))->with('success', 'Paiement supprime.');
    }

    private function routeName(string $action): string
    {
        $adminRoute = 'admin.paiements.'.$action;
        if (Route::has($adminRoute) && request()->routeIs('admin.*')) {
            return $adminRoute;
        }

        return 'paiements.'.$action;
    }
}
