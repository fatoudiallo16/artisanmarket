<?php

namespace App\Services;

use App\Models\Paiement;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class InvoiceService
{
    public function generateInvoiceNumber(Paiement $paiement): string
    {
        if ($paiement->numero_facture) {
            return $paiement->numero_facture;
        }

        return 'AM-INV-' . now()->format('Y') . '-' . str_pad((string) $paiement->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Génère le PDF, l'enregistre sur le disque et met à jour le paiement en base.
     */
    public function generateAndStore(Paiement $paiement): Paiement
    {
        $paiement->load([
            'commande.user',
            'commande.lignecommandes.produit',
        ]);

        $numero = $this->generateInvoiceNumber($paiement);
        $relativePath = "invoices/{$numero}.pdf";

        Storage::disk('local')->makeDirectory('invoices');

        $html = View::make('pdf.invoice', [
            'paiement' => $paiement,
            'commande' => $paiement->commande,
            'lignes' => $paiement->commande->lignecommandes,
            'client' => $paiement->commande->user,
            'numero' => $numero,
            'total' => $paiement->montant,
        ])->render();

        $options = new Options();
        $options->set('isRemoteEnabled', false);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        Storage::disk('local')->put($relativePath, $dompdf->output());

        $paiement->update([
            'numero_facture' => $numero,
            'facture_pdf' => $relativePath,
        ]);

        return $paiement->fresh();
    }

    public function absolutePath(Paiement $paiement): ?string
    {
        if (!$paiement->facture_pdf) {
            return null;
        }

        $path = Storage::disk('local')->path($paiement->facture_pdf);

        return is_file($path) ? $path : null;
    }
}
