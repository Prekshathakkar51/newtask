<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        // $dashboardData = $this->getDashboardData();

        // DB::enableQueryLog();

        $users = User::orderBy('name')->get();

        $dashboardData = $this->getDashboardData(
            Task::query()
        );

        return view(
            'pages.dashboard.ecommerce',
            array_merge(
                $dashboardData,
                [
                    'users' => $users,
                ]
            )
        );

        // return view(
        //     'pages.dashboard.ecommerce',
        //     compact(
        //         'users',
        //         'totalTasks',
        //         'pendingTasks',
        //         'inProgressTasks',
        //         'completedTasks',
        //         'overdueTasks',
        //         'totalTeamMembers',
        //         'statusDistribution',
        //         'priorityChartData',
        //         'monthlyTaskCreationData',
        //         'taskCompletionTrend'
        //     )
        // );

    }

    public function filter(Request $request)
    {
        $query = Task::query();

        if ($request->filled('user_id')) {
            $query->where(
                'assigned_user_id',
                $request->user_id
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        if ($request->filled('from_date')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->filled('to_date')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
        }

        return response()->json(
            $this->getDashboardData($query)
        );
    }

    private function getDashboardData($query)
    {
        //  if we fetch all one by one then there are 66 queries ,  but now optimized to 5 queries

        // $tasks = Task::all();

        $tasks = $query->get();

        $totalTasks = $tasks->count();

        $pendingTasks = $tasks
            ->where('status', 'pending')
            ->count();

        $inProgressTasks = $tasks
            ->where('status', 'in_progress')
            ->count();

        $completedTasks = $tasks
            ->where('status', 'completed')
            ->count();

        $overdueTasks = $tasks
            ->filter(function ($task) {
                return $task->due_date->lt(today())
                    && $task->status !== 'completed';
            })
            ->count();

        $totalTeamMembers = User::count();

        $statusDistribution = [
            $pendingTasks,
            $inProgressTasks,
            $completedTasks,
            $overdueTasks,
        ];

        $priorityStatusCounts = (clone $query)
            ->selectRaw(
                'priority, status, COUNT(*) as total'
            )
            ->groupBy('priority', 'status')
            ->get();

        $priorityChartData = [

            'pending' => [0, 0, 0],

            'in_progress' => [0, 0, 0],

            'completed' => [0, 0, 0],

        ];

        foreach ($priorityStatusCounts as $row) {

            $priorityIndex = match ($row->priority) {
                'high' => 0,
                'medium' => 1,
                'low' => 2,
            };

            $priorityChartData[$row->status][$priorityIndex]
                = $row->total;
        }

        $monthlyTaskCreation = (clone $query)
            ->selectRaw('
                    MONTH(created_at) as month,
                    COUNT(*) as total
                ')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('total', 'month');

        $taskCompletionTrend = [

            'high' => [],
            'medium' => [],
            'low' => [],
        ];

        $monthlyTaskCreationData = array_fill(0, 12, 0);

        foreach ($monthlyTaskCreation as $month => $count) {

            $monthlyTaskCreationData[$month - 1] = $count;
        }

        $taskCompletionTrend = [

            'high' => array_fill(0, 12, 0),

            'medium' => array_fill(0, 12, 0),

            'low' => array_fill(0, 12, 0),
        ];

        $completionData = (clone $query)
            ->selectRaw('
        MONTH(completed_at) as month,
        priority,
        COUNT(*) as total
    ')
            ->whereNotNull('completed_at')
            ->whereYear('completed_at', now()->year)
            ->groupBy('month', 'priority')
            ->get();

        foreach ($completionData as $row) {

            $taskCompletionTrend[$row->priority][$row->month - 1]
                = $row->total;
        }

        // dd(count(DB::getQueryLog()));

        //         dd([
        //     'collection_pending' => $tasks->where('status', 'pending')->count(),
        //     'db_pending' => $statusCounts['pending'] ?? 0,
        // ]);

        // dd(
        //     $tasks->pluck('status')
        // );

        return [
            'totalTasks' => $totalTasks,
            'pendingTasks' => $pendingTasks,
            'inProgressTasks' => $inProgressTasks,
            'completedTasks' => $completedTasks,
            'overdueTasks' => $overdueTasks,
            'totalTeamMembers' => $totalTeamMembers,
            'statusDistribution' => $statusDistribution,
            'priorityChartData' => $priorityChartData,
            'monthlyTaskCreationData' => $monthlyTaskCreationData,
            'taskCompletionTrend' => $taskCompletionTrend,
        ];
    }

    //     public function filter(Request $request)
    // {
    //     $baseQuery = Task::query();

    //     // apply filters

    //     return response()->json(
    //         $this->getDashboardData($baseQuery)
    //     );
    // }
}
