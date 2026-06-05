<?php

namespace App\Exports;

use App\Models\Task;
use App\Services\TaskFilterService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TasksExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected Request $request;

    protected TaskFilterService $taskFilterService;

    public function __construct(Request $request, TaskFilterService $taskFilterService) {
        $this->request = $request;
        $this->taskFilterService = $taskFilterService;
    }

    public function collection()
    {
        $query = Task::with('assignedUser');

        $this->taskFilterService->apply(
            $query,
            $this->request
        );

        return $query->get()->map(function ($task) {

            return [
                $task->title,
                $task->description,
                $task->assignedUser?->name ?? '-',
                ucfirst($task->priority),
                ucfirst($task->status),
                $task->due_date?->format('Y-m-d'),
                $task->completed_at?->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Task Title',
            'Description',
            'Assigned User',
            'Priority',
            'Status',
            'Due Date',
            'Completion Date',
        ];
    }
}
