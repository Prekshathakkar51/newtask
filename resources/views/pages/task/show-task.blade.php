{{-- UI Created using AI *** , need to fix few things when need --}}

@extends('layouts.app')

@section('content')


    <x-common.page-breadcrumb pageTitle="Show Task" />

    <x-common.component-card title="Task List">

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-4 text-green-700">
                {{ session('success') }}
            </div>
        @endif


        <div
            x-data="{
                                    tasks: @js($tasks),
                                    search: '',
                                    status:'',
                                    sort:'',
                                    userId:'',
                                    fromDate: '',
                                    toDate: '',
                                    priority: '',
                                    dueToday: false,
                                    overdue: false,
                                    showDeleteModal: false,
                                    taskToDelete: null,




                                    exportTasks(format) {

                                        const params = new URLSearchParams({

                                            search: this.search,
                                            status: this.status,
                                            priority: this.priority,
                                            user_id: this.userId,
                                            from_date: this.fromDate,
                                            to_date: this.toDate,
                                            due_today: this.dueToday,
                                            overdue: this.overdue,
                                            sort: this.sort,
                                            format: format,
                                        });

                                        window.location.href =`/tasks/export?${params.toString()}`;
                                        },




                                    async fetchTasks() {

                                        try {
                                                console.log('dueToday:', this.dueToday);
                                                const response = await axios.get('/tasks', 
                                                {
                                                    params: {
                                                            search: this.search,
                                                            status: this.status,
                                                            sort: this.sort,
                                                            user_id: this.userId,
                                                            from_date: this.fromDate,
                                                            to_date: this.toDate,
                                                            priority: this.priority,
                                                            due_today: this.dueToday,
                                                            overdue: this.overdue,
                                                            }
                                                });

                                                    this.tasks = response.data.tasks;
                                                    console.log('Updated tasks:', this.tasks);
                                                    console.log('Count:', this.tasks.length);

                                            } 
                                            catch (error) {
                                                 console.error(error);
                                            }
                                                                                                                                                                    },

                                     async updateStatus(task) {
                                                                console.log(task.status);
                                                                try {
                                                                    const response = await fetch(`/tasks/${task.id}/status`, {
                                                                    method: 'PATCH',
                                                                    headers: {
                                                                    'Content-Type': 'application/json',
                                                                    'X-CSRF-TOKEN': document
                                                                    .querySelector('meta[name=csrf-token]')
                                                                    .getAttribute('content'),
                                                                    'Accept': 'application/json'
                                                                    },
                                                                    body: JSON.stringify({
                                                                            status: task.status
                                                                            })
                                      });
                                                                 const result = await response.json();

                                                                if (!response.ok) {
                                                                    alert(result.message || 'Failed to update status');
                                                                    }

                                                                } catch (error) {
                                                                    console.error(error);
                                                                    alert('Something went wrong');
                                                                    }
                                                                  },

                                                                getPriorityClass(priority) {

                                                                return {
                                                                High: 'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-400',
                                                                Medium: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400',
                                                                Low: 'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-400'
                                                                }[priority];
                                                                },
                                                                getStatusClass(status) {
                                                                return {
                                                                        pending: 'text-yellow-700',
                                                                        in_progress: 'text-blue-700',
                                                                        completed: 'text-green-700'
                                                                        }[status];
                                                                   },

                                    handleDateRange(event) {

                                        const dates = event.detail.selectedDates;

                                        this.fromDate = '';
                                        this.toDate = '';
                                        if (dates.length > 0) {
                                            this.fromDate = dates[0].toLocaleDateString('en-CA');
                                        }
                                        if (dates.length > 1) {
                                            this.toDate = dates[1].toLocaleDateString('en-CA');
                                        }

                                        this.fetchTasks();
                                    },

                                    async deleteTask() {
                if (!this.taskToDelete) return;

                try {
                    const response = await axios.delete(`/tasks/${this.taskToDelete.id}`);

                    // remove from UI immediately
                    this.tasks = this.tasks.filter(t => t.id !== this.taskToDelete.id);

                    this.showDeleteModal = false;
                    this.taskToDelete = null;

                    Alpine.store('toast').success(response.data.message ?? 'Task deleted successfully');

                } catch (error) {
                    console.error(error);
                    Alpine.store('toast').error('Failed to delete task');
                }
            },

                                                                                                                                                                                                }">

            <!-- TOP CONTROLS -->
            <div class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between text-sm">
                <!-- SEARCH -->
                <div class="w-full md:max-w-sm">
                    <input type="text" type="text" x-model="search" @input.debounce.500ms="fetchTasks()"
                        value="{{ request('search') }}" placeholder="Search by taskname or username here..."
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-600 outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
            </div>


            <div class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center  text-sm">
                <div class="flex flex-col gap-3 sm:flex-row">
                    {{-- <div class="w-full md:max-w-sm"> --}}
                        <div @date-change.window="handleDateRange($event)"> <x-form.date-picker mode="range"
                                placeholder="Select date range" /> </div>
                    </div>


                    
                    <label class="flex cursor-pointer items-center text-sm font-medium text-gray-700 dark:text-gray-400">

                        <div class="relative mr-3">

                            <input type="checkbox" x-model="dueToday" @change="fetchTasks()" class="sr-only">

                            <div :class="dueToday
                    ? 'border-brand-500 bg-brand-500'
                    : 'border-gray-300 bg-transparent'" class="flex h-5 w-5 items-center justify-center rounded-md border">

                                <svg x-show="dueToday" width="14" height="14" fill="none" viewBox="0 0 14 14">

                                    <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="white" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                            </div>

                        </div>

                        Due Today
                    </label>


                    <label class="flex cursor-pointer items-center text-sm font-medium text-gray-700 dark:text-gray-400">

                        <div class="relative mr-3">

                            <input type="checkbox" x-model="overdue" @change="fetchTasks()" class="sr-only">

                            <div :class="overdue
                    ? 'border-brand-500 bg-brand-500'
                    : 'border-gray-300 bg-transparent'" class="flex h-5 w-5 items-center justify-center rounded-md border">

                                <svg x-show="overdue" width="14" height="14" fill="none" viewBox="0 0 14 14">

                                    <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="white" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                            </div>

                        </div>

                        Overdue
                    </label>



                    {{-- <div class="w-full md:max-w-sm">
                        <input type="checkbox" x-model="dueToday" @change="fetchTasks()" />
                        <label>Due Today</label>
                        <input type="checkbox" x-model="overdue" @change="fetchTasks()" />
                        <label>Overdue</label>
                    </div> --}}
                </div>


                <div class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between text-sm">
                    <!-- FILTER + SORT -->
                    <div class="flex flex-col gap-3 sm:flex-row"> <!-- FILTER --> {{-- <input type="date" x-model="fromDate"
                            @change="fetchTasks()" class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm">
                        <input type="date" x-model="toDate" @change="fetchTasks()"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm"> --}} <select
                            x-model="userId" @change="fetchTasks()"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value=""> Select Users </option> @foreach($users as $user) <option
                                value="{{ $user->id }}">
                                {{ $user->name }}
                            </option> @endforeach
                        </select>

                        <select x-model="status" @change="fetchTasks()"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress </option>
                            <option value="completed">Completed </option>
                        </select>

                        <select x-model="priority" @change="fetchTasks()"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">Select Priority</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>

                        <!-- SORT -->

                        <select x-model="sort" @change="fetchTasks()"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                            <option value="">Sort By - Due Date/Status/Priority/Created Date</option>
                            <option value="due_date">Due Date</option>
                            <option value="status">Status</option>
                            <option value="priority">Priority</option>
                            <option value="created_date">Created Date</option>
                        </select>
                    </div>
                </div> {{-- <div
                    class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between text-sm">
                    <div class="w-full md:max-w-sm"> --}}


                        {{-- <div
                            class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between text-sm">
                            <div class="w-full md:max-w-sm">
                                <input type="checkbox" x-model="dueToday" @change="fetchTasks()" />
                                <label>Due Today</label>
                                <input type="checkbox" x-model="overdue" @change="fetchTasks()" />
                                <label>Overdue</label>
                            </div>
                        </div> --}}

                        <div class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center text-sm">
                            <div flex flex-col gap-3 sm:flex-row> {{-- <div class="flex items-center gap-5"> --}}
                                    <x-ui.button @click="exportTasks('csv')" size="sm" variant="primary">
                                        Export CSV</x-ui.button>


                                </div>

                                <div flex gap-4>
                                    <x-ui.button @click="exportTasks('xlsx')" size="sm" variant="primary">
                                        Export Excel</x-ui.button>
                                </div>
                            </div>
                            <!-- TABLE -->
                            <div class="overflow-x-auto text-sm">

                                <table class="w-full">

                                    <thead
                                        class="border-y border-gray-100 bg-gray-50 dark:border-white/[0.05] dark:bg-gray-900">

                                        <tr>

                                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">
                                                Task Name
                                            </th>

                                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">
                                                Assigned User
                                            </th>

                                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">
                                                Priority
                                            </th>

                                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">
                                                Status
                                            </th>

                                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">
                                                Due Date
                                            </th>

                                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">
                                                Attachment
                                            </th>

                                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">
                                                Actions
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        <template x-for="task in tasks" :key="task.id">

                                            <tr class="border-b border-gray-100 dark:border-white/[0.05]">

                                                <td class="px-6 py-4">
                                                    <p class="font-medium text-gray-800 dark:text-white"
                                                        x-text="task.taskName">
                                                    </p>
                                                </td>

                                                <td class="px-6 py-4">
                                                    <p class="text-gray-700 dark:text-gray-300" x-text="task.assignedUser">
                                                    </p>
                                                </td>

                                                <td class="px-6 py-4">

                                                    <span class="rounded-full px-3 py-1 text-xs font-medium"
                                                        :class="getPriorityClass(task.priority)"
                                                        x-text="task.priority"></span>

                                                </td>

                                                <td class="px-6 py-4">

                                                    <select x-model="task.status" @change="updateStatus(task)"
                                                        class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                                                        :class="getStatusClass(task.status)">
                                                        <option value="pending">Pending</option>
                                                        <option value="in_progress">In Progress</option>
                                                        <option value="completed">Completed</option>
                                                    </select>

                                                </td>

                                                <td class="px-6 py-4">
                                                    <p class="text-gray-700 dark:text-gray-300" x-text="task.dueDate"></p>
                                                </td>

                                                <td class="px-6 py-4">

                                                    {{-- <button
                                                        class="rounded-lg bg-gray-100 px-3 py-1 text-sm text-gray-700 hover:bg-gray-200">
                                                        Preview
                                                    </button> --}}

                                                    <template x-if="task.attachment">

                                                        <a :href="'/storage/' + task.attachment" target="_blank"
                                                            class="rounded-lg bg-gray-100 px-3 py-1 text-sm text-gray-700 hover:bg-gray-200">
                                                            Preview
                                                        </a>

                                                    </template>

                                                </td>

                                                <td class="px-6 py-4">

                                                    <div class="flex items-center gap-3">

                                                        <a :href="task.editUrl" class="text-blue-500 hover:text-blue-700">
                                                            Edit
                                                        </a>

                                                        {{-- <form :action="`/tasks/${task.id}`" method="POST"
                                                            onsubmit="return confirm('Are you sure you want to delete this task?')">

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                                Delete
                                                            </button>

                                                        </form> --}}

                                                        <button @click="taskToDelete = task; showDeleteModal = true"
                                                            class="text-red-500 hover:text-red-700">
                                                            Delete
                                                        </button>

                                                    </div>

                                                </td>

                                            </tr>

                                        </template>

                                    </tbody>

                                </table>

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

                            <!-- DELETE CONFIRMATION MODAL -->

                            <div x-show="showDeleteModal"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" x-transition>
                                <div class="w-full max-w-md rounded-lg bg-white p-6 dark:bg-gray-900">

                                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                                        Delete Task
                                    </h2>

                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                                        Are you sure you want to delete this task? This action cannot be undone.
                                    </p>

                                    <div class="mt-6 flex justify-end gap-3">

                                        <button @click="showDeleteModal = false; taskToDelete = null"
                                            class="rounded-lg border px-4 py-2 text-sm">
                                            Cancel
                                        </button>

                                        <button @click="deleteTask()"
                                            class="rounded-lg bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700">
                                            Delete
                                        </button>

                                    </div>

                                </div>
                            </div>

                        </div>



    </x-common.component-card>

@endsection