<?php

namespace App\Services;

use Illuminate\Http\Request;

class TaskFilterService
{
    public function apply($query, Request $request)
    {
        // Search
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('title', 'like', '%' . $request->search . '%')

                    ->orWhereHas('assignedUser', function ($userQuery) use ($request) {

                        $userQuery->where(
                            'name',
                            'like',
                            '%' . $request->search . '%'
                        );
                    });
            });
        }

        // Status
        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        // Priority
        if ($request->filled('priority')) {

            $query->where(
                'priority',
                $request->priority
            );
        }

        // User
        if ($request->filled('user_id')) {

            $query->where(
                'assigned_user_id',
                $request->user_id
            );
        }

        // Due Today
        if ($request->boolean('due_today')) {

            $query->whereDate(
                'due_date',
                today()
            );
        }

        // Overdue
        if ($request->boolean('overdue')) {

            $query->whereDate(
                'due_date',
                '<',
                today()
            )
            ->where(
                'status',
                '!=',
                'completed'
            );
        }

        // Date Range
        if ($request->filled('from_date')) {

            $query->whereDate(
                'due_date',
                '>=',
                $request->from_date
            );
        }

        if ($request->filled('to_date')) {

            $query->whereDate(
                'due_date',
                '<=',
                $request->to_date
            );
        }

        return $query;
    }
}