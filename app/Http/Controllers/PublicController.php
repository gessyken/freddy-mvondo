<?php

namespace App\Http\Controllers;

use App\Models\CivilAct;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        return view('public.index');
    }

    /**
     * Display information about civil acts.
     */
    public function information()
    {
        return view('public.information');
    }

    /**
     * Verify a civil act by reference number or QR code.
     */
    public function verifyAct(Request $request)
    {
        $referenceNumber = $request->input('reference_number');
        
        if (!$referenceNumber) {
            return view('public.verify', ['error' => 'Veuillez fournir un numéro de référence.']);
        }

        $civilAct = CivilAct::where('reference_number', $referenceNumber)
            ->where('status', 'validated')
            ->first();

        if (!$civilAct) {
            return view('public.verify', [
                'error' => 'Aucun acte valide trouvé avec ce numéro de référence.',
                'reference_number' => $referenceNumber,
            ]);
        }

        return view('public.verify-result', compact('civilAct'));
    }

    /**
     * Download a civil act PDF (public access).
     */
    public function downloadAct(CivilAct $civilAct)
    {
        if ($civilAct->status !== 'validated' || !$civilAct->pdf_path) {
            abort(404, 'Acte non disponible.');
        }

        if (!\Storage::exists($civilAct->pdf_path)) {
            abort(404, 'Fichier PDF non trouvé.');
        }

        return \Storage::download($civilAct->pdf_path, 'acte-' . $civilAct->reference_number . '.pdf');
    }

    /**
     * Display contact information.
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Display FAQ.
     */
    public function faq()
    {
        $faqs = [
            [
                'question' => 'Quels sont les délais pour déclarer une naissance ?',
                'answer' => 'La déclaration de naissance doit être faite dans les 30 jours suivant la naissance. Au-delà de ce délai, une procédure spéciale est nécessaire.',
            ],
            [
                'question' => 'Quels documents sont requis pour un acte de naissance ?',
                'answer' => 'Pour un acte de naissance, vous devez fournir : la déclaration de naissance, une photocopie de la CNI des parents, et une photocopie de la CNI des témoins.',
            ],
            [
                'question' => 'Comment puis-je payer les frais ?',
                'answer' => 'Les paiements peuvent être effectués via Mobile Money ou par virement bancaire. Le montant varie selon le type d\'acte demandé.',
            ],
            [
                'question' => 'Combien de temps faut-il pour traiter ma demande ?',
                'answer' => 'Le traitement d\'une demande prend généralement 3 à 5 jours ouvrables après réception du paiement et validation des documents.',
            ],
            [
                'question' => 'Comment puis-je vérifier l\'authenticité d\'un acte ?',
                'answer' => 'Vous pouvez utiliser le numéro de référence ou scanner le QR code présent sur l\'acte pour vérifier son authenticité sur notre site.',
            ],
        ];

        return view('public.faq', compact('faqs'));
    }
}