@extends('layouts.app')

@section('content')

    <x-common.page-breadcrumb pageTitle="Deleted Tasks" />

    <x-common.component-card title="Deleted Tasks">

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto text-sm">

            <div x-data="deletedTasks">

                <table class="w-full">

                    <thead class="border-y border-gray-100 bg-gray-50 dark:border-white/[0.05] dark:bg-gray-900">

                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Task Name</th>

                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Assigned User</th>

                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Deleted At</th>

                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Action</th>
                        </tr>

                    </thead>

                    <tbody>



                        @forelse($tasks as $task)

                            <tr id="task-{{ $task->id }}" class=" text-sm border-b border-gray-100 dark:border-white/[0.05]">

                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800 dark:text-white">{{ $task->title }}</p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        {{ $task->assignedUser?->name ?? '-' }}
                                    </p>
                                </td>

                                <td class="px-6 py-4">
                                    <p class="text-gray-700 dark:text-gray-300">
                                        {{ $task->deleted_at }}
                                    </p>
                                </td>

                                <td class="px-6 py-4">

                                    <button type="button" class="text-green-500 hover:text-green-700"
                                        @click="restoreTask({{ $task->id }}, $el)">
                                        Restore
                                    </button>


                                </td>

                            </tr>

                        @empty

                            <tr class="border-b border-gray-100 text-gray-400 dark:border-white/[0.05]">

                                <td colspan="4" class="px-6 py-6 text-center">

                                    No deleted tasks found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <!-- PAGINATION -->
        {{-- <div class="flex items-center justify-between px-6 py-4">

            <button @click="prevPage"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                Previous
            </button>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Page <span x-text="currentPage"></span> of <span x-text="totalPages"></span>
            </p>

            <button @click="nextPage"
                class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                Next
            </button>

        </div> --}}

    </x-common.component-card>

@endsection


<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('deletedTasks', () => ({

            async restoreTask(taskId, button) {
                try {
                    button.disabled = true;

                    const response = await axios.post(`/tasks/${taskId}/restore`, {
                        _token: document.querySelector('meta[name="csrf-token"]').content
                    });

                    console.log(response.data); // DEBUG (important)

                    Alpine.store('toast').success(response.data.message);

                    document.getElementById(`task-${taskId}`).remove();

                } catch (error) {

                    console.log('ERROR:', error); // DEBUG

                    Alpine.store('toast').error(
                        error.response?.data?.message ?? 'Something went wrong'
                    );

                    button.disabled = false;
                }
            }

        }));
    });
</script>