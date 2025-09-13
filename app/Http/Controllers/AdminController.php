<?php

namespace App\Http\Controllers;

use App\Models\CivilAct;
use App\Models\Configuration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        // Gestion des périodes
        $period = $request->input('period', 'this_month');
        
        // Ajuster les dates selon la période sélectionnée
        switch ($period) {
            case 'this_month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'last_month':
                $startDate = now()->subMonth()->startOfMonth();
                $endDate = now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            case 'custom':
                $startDate = $request->input('date_from') ? now()->parse($request->input('date_from'))->startOfDay() : now()->startOfMonth();
                $endDate = $request->input('date_to') ? now()->parse($request->input('date_to'))->endOfDay() : now()->endOfMonth();
                break;
            default:
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
        }

        // Statistiques générales
        $totalActs = CivilAct::whereBetween('created_at', [$startDate, $endDate])->count();
        $validatedActs = CivilAct::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'validated')->count();
        $pendingActs = CivilAct::whereBetween('created_at', [$startDate, $endDate])
            ->whereIn('status', ['submitted', 'in_review'])->count();
        $totalRevenue = CivilAct::whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->sum('amount');

        // Données pour les graphiques
        $typeStats = CivilAct::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        $statusStats = CivilAct::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $revenueStats = CivilAct::whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->selectRaw('strftime("%Y-%m", created_at) as month, SUM(amount) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('revenue', 'month')
            ->toArray();

        // Données mensuelles détaillées
        $monthlyData = [];
        $current = $startDate->copy();
        while ($current <= $endDate) {
            $month = $current->format('Y-m');
            $monthStart = $current->copy()->startOfMonth();
            $monthEnd = $current->copy()->endOfMonth();
            
            $monthlyActs = CivilAct::whereBetween('created_at', [$monthStart, $monthEnd])
                ->where('payment_status', 'paid')
                ->get();
            
            $monthlyData[$month] = [
                'birth' => $monthlyActs->where('type', 'birth')->count(),
                'marriage' => $monthlyActs->where('type', 'marriage')->count(),
                'death' => $monthlyActs->where('type', 'death')->count(),
                'total' => $monthlyActs->count(),
                'revenue' => $monthlyActs->sum('amount')
            ];
            
            $current->addMonth();
        }

        $stats = [
            'total_acts' => $totalActs,
            'validated_acts' => $validatedActs,
            'pending_acts' => $pendingActs,
            'total_revenue' => $totalRevenue
        ];

        return view('admin.reports', compact(
            'stats', 'typeStats', 'statusStats', 'revenueStats', 
            'monthlyData', 'startDate', 'endDate', 'period'
        ));
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
     * Show the form for creating a new user.
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:citizen,agent,admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified user.
     */
    public function showUser(User $user)
    {
        $user->load(['civilActs' => function($query) {
            $query->latest()->limit(10);
        }]);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:citizen,agent,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.users')
            ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Toggle user status.
     */
    public function toggleUserStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas modifier votre propre statut.');
        }

        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activé' : 'désactivé';
        
        return redirect()->route('admin.users')
            ->with('success', "Utilisateur {$status} avec succès.");
    }
}