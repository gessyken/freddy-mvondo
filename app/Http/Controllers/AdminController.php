<?php

namespace App\Http\Controllers;

use App\Models\CivilAct;
use App\Models\Configuration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        // Middlewares are now handled in routes
    }

    /**
     * Display admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_citizens' => User::where('role', 'citizen')->count(),
            'total_agents' => User::where('role', 'agent')->count(),
            'total_acts_this_month' => CivilAct::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'pending_acts' => CivilAct::whereIn('status', ['pending_payment', 'under_review'])->count(),
            'validated_acts_today' => CivilAct::where('status', 'validated')
                ->whereDate('validated_at', today())
                ->count(),
            'total_revenue' => CivilAct::where('payment_status', 'paid')
                ->sum('amount'),
        ];

        $recentActs = CivilAct::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentActs'));
    }

    /**
     * Display all civil acts.
     */
    public function civilActs()
    {
        $civilActs = CivilAct::with(['user', 'documents', 'payments'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.civil-acts', compact('civilActs'));
    }

    /**
     * Display all users.
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Display configuration settings.
     */
    public function configuration()
    {
        $pricing = Configuration::getPricing();
        $deadlines = Configuration::getDeadlines();
        
        return view('admin.configuration', compact('pricing', 'deadlines'));
    }

    /**
     * Update configuration settings.
     */
    public function updateConfiguration(Request $request)
    {
        $request->validate([
            'pricing.birth_certificate' => 'required|numeric|min:0',
            'pricing.marriage_certificate' => 'required|numeric|min:0',
            'pricing.death_certificate' => 'required|numeric|min:0',
            'deadlines.birth_declaration' => 'required|integer|min:0',
            'deadlines.marriage_declaration' => 'required|integer|min:0',
            'deadlines.death_declaration' => 'required|integer|min:0',
        ]);

        foreach ($request->pricing as $key => $value) {
            Configuration::setValue("pricing.{$key}", $value, 'float', "Prix pour {$key}", true);
        }

        foreach ($request->deadlines as $key => $value) {
            Configuration::setValue("deadlines.{$key}", $value, 'integer', "Délai pour {$key}", true);
        }

        return redirect()->route('admin.configuration')
            ->with('success', 'Configuration mise à jour avec succès.');
    }

    /**
     * Generate reports.
     */
    public function reports(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        $reports = [
            'acts_by_type' => CivilAct::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->get(),
            'acts_by_status' => CivilAct::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'revenue_by_month' => CivilAct::whereBetween('created_at', [$startDate, $endDate])
                ->where('payment_status', 'paid')
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(amount) as revenue')
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
        ];

        return view('admin.reports', compact('reports', 'startDate', 'endDate'));
    }

    /**
     * Export reports to CSV.
     */
    public function exportReports(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());

        $civilActs = CivilAct::with(['user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $filename = 'rapport_actes_' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($civilActs) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Référence',
                'Type',
                'Statut',
                'Citoyen',
                'Email',
                'Montant',
                'Statut Paiement',
                'Date de création',
                'Date de validation',
            ]);

            // CSV data
            foreach ($civilActs as $act) {
                fputcsv($file, [
                    $act->reference_number,
                    $act->type_label,
                    $act->status_label,
                    $act->user->name,
                    $act->user->email,
                    $act->amount,
                    $act->payment_status,
                    $act->created_at->format('Y-m-d H:i:s'),
                    $act->validated_at ? $act->validated_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Toggle user status.
     */
    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activé' : 'désactivé';
        
        return redirect()->route('admin.users')
            ->with('success', "Utilisateur {$status} avec succès.");
    }
}