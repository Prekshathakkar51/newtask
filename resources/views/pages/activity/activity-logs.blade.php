@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Activity Logs" />

<x-common.component-card title="System Activity Logs">

    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

            <thead>
                <tr>
                    <th>User</th>
                    <th>Description</th>
                    <th>Action</th>
                    <th>Date & Time</th>
                </tr>
            </thead>

            <tbody>

                @foreach($activities as $activity)

                @php
        $taskTitle =
            data_get($activity->properties, 'attributes.title')
            ?? data_get($activity->properties, 'old.title')
            ?? 'Unknown Task';
    @endphp

                    <tr>

                        <td>
                            {{ $activity->causer?->name ?? 'System' }}
                        </td>

                        <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-300">

    @switch($activity->description)

        @case('Task created')
            Created task "{{ $taskTitle }}"
            @break

        @case('Task updated')
            Updated task "{{ $taskTitle }}"
            @break

        @case('Task deleted')
            Deleted task "{{ $taskTitle }}"
            @break

        @case('Task restored')
            Restored task "{{ $taskTitle }}"
            @break

        @case('Status Changed')
            Status changed from
            "{{ ucfirst(data_get($activity->properties, 'from')) }}"
            to
            "{{ ucfirst(data_get($activity->properties, 'to')) }}"
            for task "{{ $taskTitle }}"
            @break

        @case('File Uploaded')
            Uploaded file
            "{{ data_get($activity->properties, 'file_name') }}"
            to task "{{ $taskTitle }}"
            @break

        @default
            {{ $activity->description }}

    @endswitch

</td>

                        <td class="px-5 py-4 text-sm font-medium">

    @switch($activity->description)

        @case('Task created')
            <span >Task Created</span>
            @break

        @case('Task updated')
            <span >Task Updated</span>
            @break

        @case('Task deleted')
            <span >Task Deleted</span>
            @break

        @case('Task restored')
            <span >Task Restored</span>
            @break

        @case('Status Changed')
            <span >Status Changed</span>
            @break

        @case('File Uploaded')
            <span >File Uploaded</span>
            @break

        @default
            {{ $activity->description }}

    @endswitch

</td>

                       <td class="px-5 py-4 text-sm text-gray-500">

    {{ $activity->created_at->format('d M Y, h:i A') }}

</td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="mt-6">
    {{ $activities->links() }}
</div>
</x-common.component-card>

@endsection




{{-- @extends('layouts.app')

@section('content')

    <x-common.page-breadcrumb pageTitle="Activity Logs" />

    <x-common.component-card title="Activity Logs">

        <table class="min-w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Action</th>
                    <th>User</th>
                    <th>Task</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($activities as $activity)
                    <tr>
                        <td>{{ $activity->id }}</td>
                        <td>{{ $activity->description }}</td>
                        <td>{{ $activity->causer?->name }}</td>
                        <td>{{ $activity->subject?->title }}</td>
                        <td>{{ $activity->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </x-common.component-card>

@endsection --}}