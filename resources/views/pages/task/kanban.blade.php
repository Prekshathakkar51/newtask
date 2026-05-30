@extends('layouts.app')

@section('content')

  <x-common.page-breadcrumb pageTitle="Kanban" />


  <x-common.component-card title="Update your task status with a visual kanban board">

<div class="p-6">

    <div x-data="kanbanBoard" class="flex gap-6 overflow-x-auto">

        <template x-for="lane in lanes" :key="lane.id">

            <div class="w-80 flex-shrink-0">

                <!-- Header -->
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white"
                        x-text="lane.name"></h2>

                    <span class="px-2 py-1 text-xs rounded-full"
                          :class="lane.badgeClass"
                          x-text="lane.tasks.length"></span>
                </div>

                <!-- Lane -->
                <div class="bg-gray-100 dark:bg-white/[0.03] rounded-xl p-4 min-h-[500px]"
                     @dragover.prevent
                     @drop="handleDrop($event, lane.id)">

                    <template x-for="task in lane.tasks" :key="task.id">

                        <!-- Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 mb-4 shadow-sm cursor-move"
                             draggable="true"
                             @dragstart="handleDragStart($event, task.id, lane.id)"
                             @dragend="handleDragEnd($event)">

                            <div class="flex items-start justify-between mb-3">
                                <h3 class="font-medium text-sm text-gray-800 dark:text-white"
                                    x-text="task.title"></h3>
                            </div>

                            <div class="flex items-center justify-between mt-4">

                                <span class="text-xs text-gray-500"
                                      x-text="task.date"></span>

                                <img :src="task.user"
                                     class="w-8 h-8 rounded-full object-cover">
                            </div>

                            <template x-if="task.category">
                                <span class="inline-block mt-3 px-2 py-1 text-xs rounded-full"
                                      :class="task.categoryClass"
                                      x-text="task.category"></span>
                            </template>

                        </div>

                    </template>

                </div>

            </div>

        </template>

    </div>

</div>




</x-common.component-card>


@endsection