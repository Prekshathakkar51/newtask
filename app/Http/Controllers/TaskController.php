<?php

namespace App\Http\Controllers;

use App\Exports\TasksExport;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskFilterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    private TaskFilterService $taskFilterService;

    public function __construct(
        TaskFilterService $taskFilterService
    ) {
        $this->taskFilterService = $taskFilterService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return 'Task Listing Page';

        $query = Task::with('assignedUser');

        $this->taskFilterService->apply(
            $query,
            $request
        );

        //         logger()->info('Date Filter', [
        //     'from_date' => $request->from_date,
        //     'to_date' => $request->to_date,
        // ]);

        //        logger()->info('Due Today Filter', [
        //     'value' => $request->due_today,
        //     'type' => gettype($request->due_today),
        // ]);

        // Search
        // if ($request->filled('search')) {

        //     $query->where(function ($q) use ($request) {

        //         $q->where('title', 'like', '%'.$request->search.'%')

        //             ->orWhereHas('assignedUser', function ($userQuery) use ($request) {

        //                 $userQuery->where(
        //                     'name',
        //                     'like',
        //                     '%'.$request->search.'%'
        //                 );
        //             });
        //     });
        // }

        // Status Filter
        // if ($request->filled('status')) {

        //     $query->where(
        //         'status',
        //         $request->status
        //     );
        // }

        // if ($request->filled('priority')) {

        //     $query->where(
        //         'priority',
        //         $request->priority
        //     );
        // }

        // if ($request->filled('user_id')) {

        //     $query->where(
        //         'assigned_user_id',
        //         $request->user_id
        //     );
        // }

        // if ($request->boolean('due_today')) {
        //     $query->whereDate('due_date', today());
        // }

        // if ($request->boolean('overdue')) {

        //     $query->whereDate(
        //         'due_date',
        //         '<',
        //         today()
        //     )
        //         ->where(
        //             'status',
        //             '!=',
        //             'completed'
        //         );
        // }

        // if ($request->filled('from_date')) {

        //     $query->whereDate(
        //         'due_date',
        //         '>=',
        //         $request->from_date
        //     );
        // }
        // if ($request->filled('to_date')) {

        //     $query->whereDate(
        //         'due_date',
        //         '<=',
        //         $request->to_date
        //     );
        // }

        // Sorting
        switch ($request->sort) {

            case 'due_date':
                $query->orderBy('due_date');
                break;

            case 'priority':
                $query->orderByRaw("
                FIELD(
                    priority,
                    'high',
                    'medium',
                    'low'
                )
            ");
                break;

            case 'status':
                $query->orderBy('status');
                break;

            case 'created_date':
                $query->latest();
                break;

            default:
                $query->latest();
        }

        //         dd(
        //     $request->from_date,
        //     $request->to_date
        // );

        $tasks = $query->get()->map(function ($task) {
            return [
                'id' => $task->id,
                'taskName' => $task->title,
                'assignedUser' => $task->assignedUser?->name ?? '-',
                'priority' => ucfirst($task->priority),
                'status' => $task->status,
                'statusRoute' => route('tasks.status', $task),
                'editUrl' => route('tasks.edit', $task),
                'dueDate' => $task->due_date?->format('Y-m-d'),
                'attachment' => $task->attachment,
                'createdDate' => $task->created_at?->format('Y-m-d'),
            ];
        });

        $users = User::select('id', 'name')
            ->orderBy('name')
            ->get();

        // dd($tasks);

        if ($request->ajax()) {

            return response()->json([
                'tasks' => $tasks,
            ]);
        }

        return view('pages.task.show-task', compact('tasks', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('pages.task.create-task', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request
                ->file('attachment')
                ->store('task-attachments', 'public');
        }

        $data['completed_at'] = $data['status'] === 'completed'
    ? now()
    : null;

        $task = Task::create($data);

        if ($request->hasFile('attachment')) {
            activity()
                ->performedOn($task)
                ->causedBy(auth()->user())
                ->withProperties([
                    'file_name' => $request->file('attachment')->getClientOriginalName(),
                    'task_title' => $task->title,
                ])
                ->log('File Uploaded');
        }

        // return redirect()
        //     ->route('tasks.index')
        //     ->with('success', 'Task created successfully.');

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully',
            'redirect' => route('tasks.index'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::select('id', 'name')
            ->orderBy('name')
            ->get();

        return view(
            'pages.task.edit-task',
            compact('task', 'users')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskRequest $request, Task $task)
    {
        $data = $request->validated();

        if ($request->hasFile('attachment')) {

            if ($task->attachment) {
                Storage::disk('public')->delete($task->attachment);
            }

            $data['attachment'] = $request
                ->file('attachment')
                ->store('task-attachments', 'public');
        }

        $data['completed_at'] = $data['status'] === 'completed'
        ? now()
        : null;

        $oldStatus = $task->status;


        $task->update($data);

        if ($oldStatus !== $task->status) {
            activity()
                ->performedOn($task)
                ->causedBy(auth()->user())
                ->withProperties([
                    'from' => $oldStatus,
                    'to' => $task->status,
                    'task_title' => $task->title,
                ])
                ->log('Status Changed');
        }

        if ($request->hasFile('attachment')) {
            activity()
                ->performedOn($task)
                ->causedBy(auth()->user())
                ->withProperties([
                    'file_name' => $request->file('attachment')->getClientOriginalName(),
                    'task_title' => $task->title,
                ])
                ->log('File Uploaded');
        }

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'redirect' => route('tasks.index'),
        ]);
        // return redirect()
        //     ->route('tasks.index')
        //     ->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $oldStatus = $task->status;

        $task->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'completed'
                ? now()
                : null,
        ]);

        if ($oldStatus !== $task->status) {
    activity()
        ->performedOn($task)
        ->causedBy(auth()->user())
        ->withProperties([
            'from' => $oldStatus,
            'to' => $task->status,
            'task_title' => $task->title,
            
        ])
        ->log('Status Changed');
}

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);

        // return redirect()
        //     ->route('tasks.index')
        //     ->with('success', 'Task deleted successfully.');
    }

    public function deleted()
    {
        $tasks = Task::onlyTrashed()
            ->with('assignedUser')
            ->latest()
            ->get();

        return view(
            'pages.task.deleted-tasks',
            compact('tasks')
        );

    }

    public function restore($id)
    {
        $task = Task::onlyTrashed()
            ->findOrFail($id);

        $task->restore();

        return response()->json([
            'message' => 'Task restored successfully.',
        ]);

        // return redirect()
        //     ->route('tasks.deleted')
        //     ->with('success', 'Task restored successfully.');
    }

    public function kanban()
    {
        $tasks = Task::with('assignedUser')
            ->get()
            ->map(function ($task) {

                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'status' => $task->status,
                    'priority' => $task->priority,
                    'due_date' => $task->due_date?->format('d M Y'),
                    'assigned_user' => $task->assignedUser?->name ?? 'Unassigned',
                ];
            });

        return view('pages.task.kanban', compact('tasks'));
    }

    // public function updateKanbanStatus(Request $request, Task $task)
    // {
    //     $request->validate([
    //         'status' => 'required|in:pending,in_progress,completed',
    //     ]);

    //     $task->update([
    //         'status' => $request->status,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //     ]);
    // }

    public function export(
        Request $request,
        TaskFilterService $taskFilterService
    ) {
        $format = $request->format ?? 'xlsx';

        return Excel::download(
            new TasksExport(
                $request,
                $taskFilterService
            ),
            "tasks.$format"
        );
    }
}
