<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Paiement;
use App\Services\InvoiceService;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PaiementController extends Controller
{
    public function __construct(
        private PaymentService $paymentService,
        private InvoiceService $invoiceService,
    ) {
    }

    public function index(): View
    {
        $this->authorize('viewAny', Paiement::class);

        $query = Paiement::with('commande')->latest();
        if (!Auth::user()->hasRole('admin')) {
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
        if (!Auth::user()->hasRole('admin') && (int) $commande->user_id !== (int) Auth::id()) {
            abort(403, 'Commande non autorisee pour ce paiement.');
        }

        $paiement = Paiement::create([
            'commande_id' => $commande->id,
            'montant' => $data['montant'],
            'mode_paiement' => $data['mode_paiement'],
            'statut' => $data['statut'] ?? 'en_attente',
            'date_paiement' => now(),
        ]);

        return redirect()->route($this->routeName('show'), $paiement)->with('success', 'Paiement enregistre.');
    }

    public function update(Request $request, Paiement $paiement): RedirectResponse
    {
        $this->authorize('update', $paiement);

        $data = $request->validate([
            'statut' => ['required', 'in:en_attente,paye,echoue,rembourse'],
            'mode_paiement' => ['nullable', 'string', 'max:100'],
        ]);

        $paiement->update($data);

        return redirect()->route($this->routeName('show'), $paiement)->with('success', 'Paiement mis a jour.');
    }

    public function destroy(Paiement $paiement): RedirectResponse
    {
        $this->authorize('delete', $paiement);

        $paiement->delete();

        return redirect()->route($this->routeName('index'))->with('success', 'Paiement supprime.');
    }

    public function pay(Request $request, Paiement $paiement): RedirectResponse
    {
        $this->authorize('view', $paiement);

        $data = $request->validate([
            'mode_paiement' => ['required', 'string', 'max:100'],
        ]);

        $this->paymentService->markAsPaid($paiement, $data['mode_paiement']);

        return redirect()
            ->route('paiements.show', $paiement)
            ->with('success', 'Paiement enregistre avec succes.');
    }

    public function invoice(Paiement $paiement): BinaryFileResponse
    {
        $this->authorize('view', $paiement);

        $paiement = $this->invoiceService->generateAndStore($paiement);
        $path = $this->invoiceService->absolutePath($paiement);

        abort_unless($path, 404, 'Facture introuvable.');

        return response()->download($path, ($paiement->numero_facture ?? 'facture').'.pdf');
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
