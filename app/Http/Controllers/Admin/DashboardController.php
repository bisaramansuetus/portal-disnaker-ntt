<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts' => $this->safeCount('posts', function ($q) {
                if (Schema::hasColumn('posts', 'type')) {
                    $q->where('type', 'berita');
                }
            }),
            'announcements' => $this->safeCount('posts', function ($q) {
                if (Schema::hasColumn('posts', 'type')) {
                    $q->where('type', 'pengumuman');
                }
            }),
            'jobs' => $this->safeCount('job_vacancies', function ($q) {
                if (Schema::hasColumn('job_vacancies', 'status')) {
                    // Di sistem kita, lowongan dianggap aktif jika status published
                    $q->where('status', 'published');
                }
            }),
            'programs' => $this->safeCount('programs'),
            'complaints' => $this->safeCount('complaints'),
            'ppid_pending' => $this->safeCount('ppid_requests', function ($q) {
                if (Schema::hasColumn('ppid_requests', 'status')) {
                    $q->whereIn('status', ['pending', 'proses']); // Sesuai DB kita
                }
            }),
        ];

        $attention = [
            'unresponded_complaints' => $this->safeCount('complaints', function ($q) {
                if (Schema::hasColumn('complaints', 'status')) {
                    $q->where('status', 'pending');
                }
            }),
            'pending_ppid' => $stats['ppid_pending'],
            'draft_posts' => $this->safeCount('posts', function ($q) {
                if (Schema::hasColumn('posts', 'status')) {
                    $q->where('status', 'draft');
                }
            }),
        ];

        $chartMonths = $this->buildSixMonthServiceChart();

        return view('admin.dashboard', compact('stats', 'attention', 'chartMonths'));
    }

    private function buildSixMonthServiceChart(): array
    {
        $months = [];
        $rawCounts = [];
        $maxCount = 0;

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonthsNoOverflow($i);
            $year = (int) $date->format('Y');
            $month = (int) $date->format('m');

            $complaintsCount = $this->countByYearMonth('complaints', $year, $month);
            $ppidCount = $this->countByYearMonth('ppid_requests', $year, $month);
            $total = $complaintsCount + $ppidCount;

            $rawCounts[] = [
                'label' => $date->locale('id')->translatedFormat('M'),
                'complaints' => $complaintsCount,
                'ppid' => $ppidCount,
                'total' => $total,
                'is_current' => $i === 0,
            ];

            if ($total > $maxCount) {
                $maxCount = $total;
            }
        }

        foreach ($rawCounts as $item) {
            $heightPercent = $maxCount > 0
                ? max(12, (int) round(($item['total'] / $maxCount) * 100))
                : ($item['is_current'] ? 35 : 15);

            $months[] = [
                'name' => $item['label'],
                'complaints' => $item['complaints'],
                'ppid' => $item['ppid'],
                'total' => $item['total'],
                'height_percent' => $heightPercent,
                'active' => $item['is_current'],
            ];
        }

        return $months;
    }

    private function countByYearMonth(string $table, int $year, int $month): int
    {
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'created_at')) {
            return 0;
        }

        return (int) DB::table($table)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
    }

    private function safeCount(string $table, ?callable $filter = null): int
    {
        if (!Schema::hasTable($table)) {
            return 0;
        }

        $query = DB::table($table);
        if ($filter) {
            $filter($query);
        }

        return (int) $query->count();
    }
}