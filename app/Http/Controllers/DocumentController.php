<?php

namespace App\Http\Controllers;

use App\Models\CivilAct;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    public function __construct()
    {
        // Middlewares are now handled in routes
    }

    /**
     * Store a newly uploaded document.
     */
    public function store(Request $request, CivilAct $civilAct)
    {
        Gate::authorize('update', $civilAct);
        
        if ($civilAct->status !== 'draft') {
            return redirect()->route('civil-acts.show', $civilAct)
                ->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // 10MB max
            'type' => 'required|string',
            'name' => 'required|string',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid() . '.' . $extension;
        $path = $file->storeAs('documents', $filename, 'private');

        // Delete existing document of the same type
        $existingDocument = $civilAct->documents()->where('type', $request->type)->first();
        if ($existingDocument) {
            Storage::delete($existingDocument->file_path);
            $existingDocument->delete();
        }

        $document = $civilAct->documents()->create([
            'name' => $request->name,
            'type' => $request->type,
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'is_required' => $this->isRequiredDocument($civilAct->type, $request->type),
        ]);

        return redirect()->route('civil-acts.show', $civilAct)
            ->with('success', 'Document téléchargé avec succès.');
    }

    /**
     * Download a document.
     */
    public function download(CivilAct $civilAct, Document $document)
    {
        Gate::authorize('view', $civilAct);
        
        if (!Storage::exists($document->file_path)) {
            abort(404, 'Fichier non trouvé.');
        }

        return Storage::download($document->file_path, $document->name . '.' . $document->file_extension);
    }

    /**
     * Delete a document.
     */
    public function destroy(CivilAct $civilAct, Document $document)
    {
        Gate::authorize('update', $civilAct);
        
        if ($civilAct->status !== 'draft') {
            return redirect()->route('civil-acts.show', $civilAct)
                ->with('error', 'Cette demande ne peut plus être modifiée.');
        }

        Storage::delete($document->file_path);
        $document->delete();

        return redirect()->route('civil-acts.show', $civilAct)
            ->with('success', 'Document supprimé avec succès.');
    }

    /**
     * Validate a document (for agents).
     */
    public function validate(CivilAct $civilAct, Document $document, Request $request)
    {
        Gate::authorize('validate', $civilAct);
        
        $request->validate([
            'is_validated' => 'required|boolean',
            'validation_notes' => 'nullable|string',
        ]);

        $document->update([
            'is_validated' => $request->is_validated,
            'validation_notes' => $request->validation_notes,
        ]);

        $status = $request->is_validated ? 'validé' : 'rejeté';
        
        return redirect()->route('civil-acts.show', $civilAct)
            ->with('success', "Document {$status} avec succès.");
    }

    /**
     * Check if a document type is required for a civil act type.
     */
    private function isRequiredDocument(string $civilActType, string $documentType): bool
    {
        $requiredDocuments = [
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
        ];

        return in_array($documentType, $requiredDocuments[$civilActType] ?? []);
    }
}