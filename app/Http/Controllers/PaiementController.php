<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use App\Models\User;
use App\Services\InvoiceService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaiementController extends Controller
{
    public function __construct(
        private PaymentService $paymentService,
        private InvoiceService $invoiceService
    ) {
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
        $paiement->load('commande.lignecommandes.produit', 'commande.user');

        return view('paiements.show', compact('paiement'));
    }

    public function pay(Request $request, Paiement $paiement): RedirectResponse
    {
        $this->authorize('pay', $paiement);

        if ($paiement->statut !== 'en_attente') {
            return redirect()
                ->route('commandes.show', $paiement->commande_id)
                ->with('error', 'Ce paiement ne peut plus être validé.');
        }

        $data = $request->validate([
            'mode_paiement' => ['required', 'in:carte,mobile_money,virement,especes,en_ligne'],
        ]);

        $paiement = $this->paymentService->markAsPaid($paiement, $data['mode_paiement']);

        return redirect()
            ->route('paiements.show', $paiement)
            ->with('success', 'Paiement enregistré. Facture ' . $paiement->numero_facture . ' disponible au téléchargement.');
    }

    public function invoice(Paiement $paiement): StreamedResponse
    {
        $this->authorize('view', $paiement);

        if ($paiement->statut !== 'paye') {
            abort(404, 'Facture disponible uniquement pour les paiements validés.');
        }

        if (!$paiement->facture_pdf || !Storage::disk('local')->exists($paiement->facture_pdf)) {
            $paiement = $this->invoiceService->generateAndStore($paiement);
        }

        $filename = ($paiement->numero_facture ?? 'facture-' . $paiement->id) . '.pdf';

        return Storage::disk('local')->download($paiement->facture_pdf, $filename, [
            'Content-Type' => 'application/pdf',
        ]);
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

        if (($data['statut'] ?? null) === 'paye') {
            $paiement = $this->paymentService->markAsPaid($paiement, $data['mode_paiement']);
        }

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
            $this->paymentService->markAsPaid($paiement, $data['mode_paiement'] ?? null);
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

        if ($paiement->facture_pdf) {
            Storage::disk('local')->delete($paiement->facture_pdf);
        }

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
