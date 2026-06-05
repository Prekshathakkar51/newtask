@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Kanban" />

<x-common.component-card title="Kanban Board">

<div class="p-6">

    <div x-data="kanbanBoard(@js($tasks))" x-init="init()" class="flex gap-6 overflow-x-auto">

        <template x-for="lane in lanes" :key="lane.id">

            <div class="w-80 flex-shrink-0">

                <!-- Lane Header -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90" x-text="lane.name"></h2>

                    <span class="px-2 py-1 text-xs rounded-full bg-gray-200"
                          x-text="lane.tasks.length"></span>
                </div>

                <!-- Lane -->
                <div class="bg-gray-100 dark:bg-white/[0.03] rounded-xl p-4 min-h-[500px]"
                     :id="'lane-' + lane.id"
                     :data-lane-id="lane.id">

                    <template x-for="task in lane.tasks" :key="task.id">

                        <div class="bg-white dark:bg-gray-900 rounded-xl p-4 mb-3 shadow cursor-move">

                            <div class="font-medium text-sm dark:text-white/90" x-text="task.title"></div>

                            <div class="text-xs text-gray-500 mt-1"
                                 x-text="task.assigned_user"></div>

                            <div class="text-xs text-gray-500"
                                 x-text="'Due Date: ' + task.due_date"></div>

                            <div class="inline-block mt-3 px-2 py-1 text-xs rounded-full"
                                 :class="{
                                    'bg-yellow-100 text-yellow-700': task.priority === 'medium',
                                    'bg-red-100 text-red-700': task.priority === 'high',
                                    'bg-green-100 text-green-700': task.priority === 'low'
                                 }"
                                 x-text="task.priority">
                            </div>

                        </div>

                    </template>

                </div>

            </div>

        </template>

    </div>

</div>

</x-common.component-card>

@endsection



{{-- @extends('layouts.app')

@section('content')

    <x-common.page-breadcrumb pageTitle="Kanban" />


    <x-common.component-card title="Update your task status with a visual kanban board">

        <div class="p-6">

            <div x-data="kanbanBoard(@js($tasks))" class="flex gap-6 overflow-x-auto">

                <template x-for="lane in lanes" :key="lane.id">

                    <div class="w-80 flex-shrink-0">

                        <!-- Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white" x-text="lane.name"></h2>

                            <span class="px-2 py-1 text-xs rounded-full" :class="lane.badgeClass"
                                x-text="lane.tasks.length"></span>
                        </div>

                        <!-- Lane -->
                        <div class="bg-gray-100 dark:bg-white/[0.03] rounded-xl p-4 min-h-[500px]" @dragover.prevent
                            @drop="handleDrop($event, lane.id)">

                            <template x-for="task in lane.tasks" :key="task.id">

                                <!-- Card -->
                                <div class="bg-white dark:bg-gray-900 rounded-xl p-4 mb-4 shadow-sm cursor-move"
                                    draggable="true" @dragstart="handleDragStart(task.id, lane.id)"
                                    @dragend="handleDragEnd()">

                                    <div class="flex items-start justify-between mb-3">
                                        <h3 class="font-medium text-sm text-gray-800 dark:text-white" x-text="task.title">
                                        </h3>
                                    </div>

                                    <div class="mt-3 text-xs text-gray-500" x-text="task.assigned_user">
                                    </div>

                                    <div class="mt-2 text-xs text-gray-500" x-text="task.due_date">
                                    </div>

                                    <span class="inline-block mt-3 px-2 py-1 text-xs rounded-full" :class="{
                'bg-red-100 text-red-700': task.priority === 'high',
                'bg-yellow-100 text-yellow-700': task.priority === 'medium',
                'bg-green-100 text-green-700': task.priority === 'low'
            }" x-text="task.priority">
                                    </span>

                                </div>

                            </template>

                        </div>

                    </div>

                </template>

            </div>

        </div>




    </x-common.component-card>


@endsection --}}