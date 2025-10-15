<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\SupportContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Spatie\Analytics\Facades\Analytics;
// use Spatie\Analytics\Period;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with analytics
     */
    public function dashboard()
    {
        // Platform Statistics
        $stats = [
            'total_users' => User::count(),
            'total_listings' => Item::count(),
            'active_listings' => Item::where('is_sold', false)->count(),
            'sold_listings' => Item::where('is_sold', true)->count(),
            'total_transactions' => Transaction::where('status', 'completed')->count(),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
        ];

        // Recent Activity
        $recentUsers = User::latest()->take(5)->get();
        $recentListings = Item::with(['user', 'category'])->latest()->take(5)->get();
        $recentTransactions = Transaction::with(['item', 'seller', 'buyer'])
            ->where('status', 'completed')
            ->latest('completed_at')
            ->take(5)
            ->get();

        // Category Distribution
        $categoryStats = Item::select('category_id', DB::raw('count(*) as total'))
            ->with('category')
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->category->name ?? 'Unknown',
                    'total' => $item->total,
                ];
            });

        // Monthly Trends (last 6 months)
        $monthlyListings = Item::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyTransactions = Transaction::select(
                DB::raw('DATE_FORMAT(completed_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Revenue Analytics (sum of sold items)
        $totalRevenue = Transaction::join('items', 'transactions.item_id', '=', 'items.id')
            ->where('transactions.status', 'completed')
            ->sum('items.price');

        $monthlyRevenue = Transaction::join('items', 'transactions.item_id', '=', 'items.id')
            ->select(
                DB::raw('DATE_FORMAT(transactions.completed_at, "%Y-%m") as month'),
                DB::raw('SUM(items.price) as revenue')
            )
            ->where('transactions.status', 'completed')
            ->where('transactions.completed_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Try to get Google Analytics data (with fallback)
        // $analyticsData = $this->getAnalyticsData();
        $analyticsData = null; // Disabled Google Analytics in favor of SimpleAnalytics

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentListings',
            'recentTransactions',
            'categoryStats',
            'monthlyListings',
            'monthlyTransactions',
            'totalRevenue',
            'monthlyRevenue',
            'analyticsData'
        ));
    }

    /**
     * Get Google Analytics data
     * Disabled in favor of SimpleAnalytics
     */
    /*
    private function getAnalyticsData()
    {
        try {
            // Check if analytics is configured
            if (!config('analytics.property_id')) {
                return null;
            }

            $period = Period::days(30);

            return [
                'visitors' => Analytics::fetchTotalVisitorsAndPageViews($period),
                'pageViews' => Analytics::fetchTotalVisitorsAndPageViews($period),
                'topPages' => Analytics::fetchMostVisitedPages($period, 10),
                'topSources' => Analytics::fetchTopReferrers($period, 10),
                'deviceTypes' => Analytics::get($period, ['activeUsers'], ['deviceCategory']),
            ];
        } catch (\Exception $e) {
            // Analytics not configured or error occurred
            \Log::error('Analytics Error: ' . $e->getMessage());
            return null;
        }
    }
    */

    /**
     * Show analytics page with detailed Google Analytics data
     * Disabled in favor of SimpleAnalytics
     */
    /*
    public function analytics(Request $request)
    {
        $period = $request->get('period', 30); // Default 30 days
        $analyticsData = null;

        try {
            if (config('analytics.property_id')) {
                $analyticsPeriod = Period::days($period);

                // Fetch analytics data using corrected API calls
                $visitorsAndPageViews = Analytics::fetchTotalVisitorsAndPageViews($analyticsPeriod);

                $analyticsData = [
                    'totalVisitors' => Analytics::get($analyticsPeriod, ['activeUsers']),
                    'totalPageViews' => Analytics::get($analyticsPeriod, ['screenPageViews']),
                    'totalSessions' => Analytics::get($analyticsPeriod, ['sessions']),
                    'avgSessionDuration' => Analytics::get($analyticsPeriod, ['averageSessionDuration']),
                    // Note: bounceRate is deprecated in GA4, using engagementRate instead
                    'bounceRate' => Analytics::get($analyticsPeriod, ['engagementRate']),

                    // Top pages
                    'topPages' => Analytics::fetchMostVisitedPages($analyticsPeriod, 20),

                    // Traffic sources
                    'trafficSources' => Analytics::get($analyticsPeriod, ['activeUsers'], ['sessionSource', 'sessionMedium'], 15),

                    // Device breakdown
                    'deviceTypes' => Analytics::get($analyticsPeriod, ['activeUsers'], ['deviceCategory']),

                    // Countries
                    'topCountries' => Analytics::get($analyticsPeriod, ['activeUsers'], ['country'], 10),

                    // Daily trend
                    'dailyVisitors' => Analytics::get($analyticsPeriod, ['activeUsers'], ['date']),
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Analytics Error: ' . $e->getMessage());
            session()->flash('analytics_error', 'Unable to fetch Google Analytics data: ' . $e->getMessage());
        }

        return view('admin.analytics', compact('analyticsData', 'period'));
    }
    */

    /**
     * Manage users
     */
    public function users()
    {
        $users = User::withCount(['items'])->latest()->paginate(20);
        return view('admin.users', compact('users'));
    }

    /**
     * Toggle admin status
     */
    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot change your own admin status.');
        }

        $user->update(['is_admin' => !$user->is_admin]);

        return redirect()->back()->with('success', 
            $user->is_admin ? 'User promoted to admin.' : 'Admin privileges revoked.');
    }

    /**
     * Manage listings
     */
    public function listings()
    {
        $listings = Item::with(['user', 'category'])
            ->latest()
            ->paginate(20);
        
        return view('admin.listings', compact('listings'));
    }

    /**
     * Delete listing
     */
    public function deleteListing(Item $item)
    {
        $item->delete();
        return redirect()->back()->with('success', 'Listing deleted successfully.');
    }

    /**
     * Manage transactions
     */
    public function transactions()
    {
        $transactions = Transaction::with(['item', 'seller', 'buyer'])
            ->latest()
            ->paginate(20);

        return view('admin.transactions', compact('transactions'));
    }

    /**
     * Display all support contact submissions
     */
    public function supportIndex(Request $request)
    {
        $query = SupportContact::with('user');

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $submissions = $query->latest()->paginate(20);

        // Get statistics for tabs
        $stats = [
            'total' => SupportContact::count(),
            'pending' => SupportContact::where('status', 'pending')->count(),
            'in_progress' => SupportContact::where('status', 'in_progress')->count(),
            'resolved' => SupportContact::where('status', 'resolved')->count(),
        ];

        return view('admin.support.index', compact('submissions', 'stats'));
    }

    /**
     * Show individual support submission
     */
    public function supportShow(SupportContact $supportContact)
    {
        $supportContact->load('user');
        return view('admin.support.show', ['submission' => $supportContact]);
    }

    /**
     * Update support submission status
     */
    public function supportUpdateStatus(Request $request, SupportContact $supportContact)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $supportContact->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    /**
     * Update support submission admin notes
     */
    public function supportUpdateNotes(Request $request, SupportContact $supportContact)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:5000',
        ]);

        $supportContact->update(['admin_notes' => $validated['admin_notes']]);

        return redirect()->back()->with('success', 'Notes updated successfully.');
    }

    /**
     * Delete support submission
     */
    public function supportDestroy(SupportContact $supportContact)
    {
        // Delete attachment if exists
        if ($supportContact->attachment_path) {
            \Storage::disk('public')->delete($supportContact->attachment_path);
        }

        $supportContact->delete();

        return redirect()->route('admin.support.index')->with('success', 'Submission deleted successfully.');
    }
}
