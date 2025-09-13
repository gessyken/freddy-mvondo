<?php

namespace App\Http\Controllers;

use App\Models\CivilAct;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CivilActController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isCitizen()) {
            $civilActs = $user->civilActs()->with(['documents', 'payments', 'messages'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            // Agents and admins can see all civil acts
            $civilActs = CivilAct::with(['user', 'documents', 'payments', 'messages'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        return view('civil-acts.index', compact('civilActs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pricing = Configuration::getPricing();
        $deadlines = Configuration::getDeadlines();
        
        return view('civil-acts.create', compact('pricing', 'deadlines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:birth,marriage,death',
            'data' => 'required|array',
        ]);

        $pricing = Configuration::getPricing();
        $amount = $pricing[$request->type . '_certificate'] ?? 0;

        $civilAct = CivilAct::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'reference_number' => CivilAct::generateReferenceNumber(),
            'data' => $request->data,
            'amount' => $amount,
            'status' => 'draft',
        ]);

        return redirect()->route('civil-acts.show', $civilAct)
            ->with('success', 'Demande créée avec succès. Vous pouvez maintenant ajouter les documents requis.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CivilAct $civilAct)
    {
        $this->authorize('view', $civilAct);
        
        $civilAct->load(['user', 'documents', 'payments', 'messages.sender', 'messages.recipient']);
        
        return view('civil-acts.show', compact('civilAct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CivilAct $civilAct)
    {
        $this->authorize('update', $civilAct);
        
        if ($civilAct->status !== 'draft') {
            return redirect()->route('civil-acts.show', $civilAct)
                ->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        $pricing = Configuration::getPricing();
        $deadlines = Configuration::getDeadlines();
        
        return view('civil-acts.edit', compact('civilAct', 'pricing', 'deadlines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CivilAct $civilAct)
    {
        $this->authorize('update', $civilAct);
        
        if ($civilAct->status !== 'draft') {
            return redirect()->route('civil-acts.show', $civilAct)
                ->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        $request->validate([
            'data' => 'required|array',
        ]);

        $civilAct->update([
            'data' => $request->data,
        ]);

        return redirect()->route('civil-acts.show', $civilAct)
            ->with('success', 'Demande mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CivilAct $civilAct)
    {
        $this->authorize('delete', $civilAct);
        
        if ($civilAct->status !== 'draft') {
            return redirect()->route('civil-acts.show', $civilAct)
                ->with('error', 'Cette demande ne peut plus être supprimée.');
        }

        // Delete associated files
        foreach ($civilAct->documents as $document) {
            Storage::delete($document->file_path);
        }
        
        if ($civilAct->pdf_path) {
            Storage::delete($civilAct->pdf_path);
        }

        $civilAct->delete();

        return redirect()->route('civil-acts.index')
            ->with('success', 'Demande supprimée avec succès.');
    }

    /**
     * Submit the civil act for review.
     */
    public function submit(CivilAct $civilAct)
    {
        $this->authorize('update', $civilAct);
        
        if ($civilAct->status !== 'draft') {
            return redirect()->route('civil-acts.show', $civilAct)
                ->with('error', 'Cette demande ne peut plus être soumise.');
        }

        // Check if all required documents are present
        $requiredDocuments = $this->getRequiredDocuments($civilAct->type);
        $uploadedDocuments = $civilAct->documents->pluck('type')->toArray();
        
        $missingDocuments = array_diff($requiredDocuments, $uploadedDocuments);
        
        if (!empty($missingDocuments)) {
            return redirect()->route('civil-acts.show', $civilAct)
                ->with('error', 'Veuillez d\'abord télécharger tous les documents requis.');
        }

        $civilAct->update([
            'status' => 'pending_payment',
            'submitted_at' => now(),
        ]);

        return redirect()->route('civil-acts.show', $civilAct)
            ->with('success', 'Demande soumise avec succès. Vous pouvez maintenant procéder au paiement.');
    }

    /**
     * Get required documents for each type of civil act.
     */
    private function getRequiredDocuments(string $type): array
    {
        return match($type) {
            'birth' => [
                'birth_declaration',
                'parent_id_copy',
                'witness_id_copy',
            ],
            'marriage' => [
                'spouse_birth_certificate',
                'spouse_id_copy',
                'celibacy_certificate',
                'domicile_certificate',
                'witness_id_copy',
                'photos',
            ],
            'death' => [
                'death_declaration',
                'declarant_id_copy',
                'witness_id_copy',
                'marriage_certificate_copy',
            ],
            default => []
        };
    }
}