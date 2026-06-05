<?php

namespace App\Http\Controllers;

use Spatie\Activitylog\Models\Activity;

use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = Activity::with(['causer'])
            ->latest()
            ->paginate(15);

        return view(
            'pages.activity.activity-logs',
            compact('activities')
        );
    }
}
