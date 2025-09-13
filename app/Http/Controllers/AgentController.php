<?php

namespace App\Http\Controllers;

use App\Models\CivilAct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:agent,admin');
    }

    /**
     * Display dashboard for agents.
     */
    public function dashboard()
    {
        $stats = [
            'pending_review' => CivilAct::where('status', 'under_review')->count(),
            'validated_today' => CivilAct::where('status', 'validated')
                ->whereDate('validated_at', today())
                ->count(),
            'rejected_today' => CivilAct::where('status', 'rejected')
                ->whereDate('rejected_at', today())
                ->count(),
            'total_this_month' => CivilAct::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        $recentActs = CivilAct::with(['user'])
            ->whereIn('status', ['under_review', 'validated', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('agent.dashboard', compact('stats', 'recentActs'));
    }

    /**
     * Display civil acts pending review.
     */
    public function pendingReview()
    {
        $civilActs = CivilAct::with(['user', 'documents', 'payments'])
            ->where('status', 'under_review')
            ->orderBy('submitted_at', 'asc')
            ->paginate(15);

        return view('agent.pending-review', compact('civilActs'));
    }

    /**
     * Validate a civil act.
     */
    public function validate(CivilAct $civilAct, Request $request)
    {
        $this->authorize('validate', $civilAct);
        
        if ($civilAct->status !== 'under_review') {
            return redirect()->route('agent.pending-review')
                ->with('error', 'Cette demande n\'est pas en cours d\'examen.');
        }

        $request->validate([
            'action' => 'required|in:validate,reject',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($request->action === 'validate') {
            $civilAct->update([
                'status' => 'validated',
                'validated_at' => now(),
            ]);

            // Generate PDF and QR code
            $this->generateActPdf($civilAct);

            // Send notification
            $this->sendValidationNotification($civilAct, 'validated');

            return redirect()->route('agent.pending-review')
                ->with('success', 'Demande validée avec succès.');
        } else {
            $civilAct->update([
                'status' => 'rejected',
                'rejected_at' => now(),
                'rejection_reason' => $request->notes,
            ]);

            // Send notification
            $this->sendValidationNotification($civilAct, 'rejected');

            return redirect()->route('agent.pending-review')
                ->with('success', 'Demande rejetée.');
        }
    }

    /**
     * Request additional documents.
     */
    public function requestDocuments(CivilAct $civilAct, Request $request)
    {
        $this->authorize('validate', $civilAct);
        
        $request->validate([
            'message' => 'required|string|max:1000',
            'document_types' => 'required|array',
        ]);

        // Create message requesting documents
        $civilAct->messages()->create([
            'sender_id' => Auth::id(),
            'recipient_id' => $civilAct->user_id,
            'message' => $request->message,
            'message_type' => 'document_request',
        ]);

        // Update status if needed
        if ($civilAct->status === 'under_review') {
            $civilAct->update(['status' => 'draft']);
        }

        return redirect()->route('civil-acts.show', $civilAct)
            ->with('success', 'Demande de documents supplémentaires envoyée.');
    }

    /**
     * Generate PDF for validated civil act.
     */
    private function generateActPdf(CivilAct $civilAct)
    {
        // This would integrate with a PDF generation library like DomPDF or TCPDF
        // For now, we'll create a placeholder
        
        $filename = 'acte-' . $civilAct->reference_number . '.pdf';
        $path = 'acts/' . $filename;
        
        // Generate QR code
        $qrCode = $this->generateQrCode($civilAct);
        
        // Store PDF path and QR code
        $civilAct->update([
            'pdf_path' => $path,
            'qr_code' => $qrCode,
            'status' => 'ready',
        ]);

        // In a real application, you would generate the actual PDF here
        \Log::info("PDF generated for civil act {$civilAct->reference_number}", [
            'path' => $path,
            'qr_code' => $qrCode,
        ]);
    }

    /**
     * Generate QR code for civil act verification.
     */
    private function generateQrCode(CivilAct $civilAct): string
    {
        $verificationUrl = route('public.verify-act', $civilAct->reference_number);
        return $verificationUrl;
    }

    /**
     * Send validation notification.
     */
    private function sendValidationNotification(CivilAct $civilAct, string $action)
    {
        // In a real application, this would send SMS/email notifications
        \Log::info("Civil act {$action}", [
            'civil_act_id' => $civilAct->id,
            'reference_number' => $civilAct->reference_number,
            'user_id' => $civilAct->user_id,
            'action' => $action,
        ]);
    }
}