
{{-- UI Created using AI *** , need to fix few things when need  --}}
@extends('layouts.app')

@section('content')

<x-common.page-breadcrumb pageTitle="Show Task" />

<x-common.component-card title="Task List">

<div
x-data="{
    search: '',
    filterStatus: '',
    sortBy: '',

    currentPage: 1,
    perPage: 5,

    tasks: [
        {
            id: 1,
            taskName: 'Fix Login Bug',
            assignedUser: 'John Doe',
            priority: 'High',
            status: 'Pending',
            dueDate: '2026-05-30',
            attachment: 'bug_report.pdf',
            createdDate: '2026-05-20'
        },
        {
            id: 2,
            taskName: 'Dashboard UI',
            assignedUser: 'Sarah Smith',
            priority: 'Medium',
            status: 'In Progress',
            dueDate: '2026-06-02',
            attachment: 'design.fig',
            createdDate: '2026-05-18'
        },
        {
            id: 3,
            taskName: 'Deploy Backend',
            assignedUser: 'Alex',
            priority: 'High',
            status: 'Completed',
            dueDate: '2026-05-28',
            attachment: 'deploy.docx',
            createdDate: '2026-05-15'
        },
        {
            id: 4,
            taskName: 'Write API Docs',
            assignedUser: 'Emma',
            priority: 'Low',
            status: 'Pending',
            dueDate: '2026-06-10',
            attachment: 'api.pdf',
            createdDate: '2026-05-10'
        },
        {
            id: 5,
            taskName: 'Database Optimization',
            assignedUser: 'Michael',
            priority: 'High',
            status: 'In Progress',
            dueDate: '2026-06-01',
            attachment: 'db.xlsx',
            createdDate: '2026-05-11'
        },
        {
            id: 6,
            taskName: 'Email Integration',
            assignedUser: 'David',
            priority: 'Medium',
            status: 'Completed',
            dueDate: '2026-05-29',
            attachment: 'mail_config.pdf',
            createdDate: '2026-05-19'
        }
    ],

    get filteredTasks() {

        let data = this.tasks.filter(task => {

            let matchesSearch =
                task.taskName.toLowerCase().includes(this.search.toLowerCase()) ||
                task.assignedUser.toLowerCase().includes(this.search.toLowerCase());

            let matchesStatus =
                this.filterStatus === '' ||
                task.status === this.filterStatus;

            return matchesSearch && matchesStatus;
        });

        if(this.sortBy === 'due_date') {
            data.sort((a,b) => new Date(a.dueDate) - new Date(b.dueDate));
        }

        if(this.sortBy === 'priority') {

            const priorityOrder = {
                High: 1,
                Medium: 2,
                Low: 3
            };

            data.sort((a,b) => priorityOrder[a.priority] - priorityOrder[b.priority]);
        }

        if(this.sortBy === 'status') {
            data.sort((a,b) => a.status.localeCompare(b.status));
        }

        if(this.sortBy === 'created_date') {
            data.sort((a,b) => new Date(b.createdDate) - new Date(a.createdDate));
        }

        return data;
    },

    get paginatedTasks() {
        const start = (this.currentPage - 1) * this.perPage;
        return this.filteredTasks.slice(start, start + this.perPage);
    },

    get totalPages() {
        return Math.ceil(this.filteredTasks.length / this.perPage);
    },

    nextPage() {
        if(this.currentPage < this.totalPages) {
            this.currentPage++;
        }
    },

    prevPage() {
        if(this.currentPage > 1) {
            this.currentPage--;
        }
    },

    getPriorityClass(priority) {

        return {

        'High':
            'bg-red-100 text-red-700 dark:bg-red-500/15 dark:text-red-400',

        'Medium':
            'bg-yellow-100 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400',

        'Low':
            'bg-green-100 text-green-700 dark:bg-green-500/15 dark:text-green-400'

    }[priority];
    },

    getStatusClass(status) {

        return {
            'Pending': ' text-yellow-700',
            'In Progress': ' text-blue-700',
            'Completed': ' text-green-700'
        }[status];
    }
}"
>

<!-- TOP CONTROLS -->
<div class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between text-sm">

    <!-- SEARCH -->
    <div class="w-full md:max-w-sm">

        <input
            type="text"
            x-model="search"
            placeholder="Search tasks..."
            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
        >

    </div>

    <!-- FILTER + SORT -->
    <div class="flex flex-col gap-3 sm:flex-row">

        <!-- FILTER -->
        <select
            x-model="filterStatus"
            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white"
        >
            <option value="">All Status</option>
            <option value="Pending">Pending</option>
            <option value="In Progress">In Progress</option>
            <option value="Completed">Completed</option>
        </select>

        <!-- SORT -->
        <select
            x-model="sortBy"
            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white"
        >
            <option value="">Sort By</option>
            <option value="due_date">Due Date</option>
            <option value="status">Status</option>
            <option value="priority">Priority</option>
            <option value="created_date">Created Date</option>
        </select>

    </div>

</div>

<!-- TABLE -->
<div class="overflow-x-auto text-sm">

<table class="w-full">

    <thead class="border-y border-gray-100 bg-gray-50 dark:border-white/[0.05] dark:bg-gray-900">

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

        <template x-for="task in paginatedTasks" :key="task.id">

            <tr class="border-b border-gray-100 dark:border-white/[0.05]">

                <td class="px-6 py-4">
                    <p class="font-medium text-gray-800 dark:text-white" x-text="task.taskName"></p>
                </td>

                <td class="px-6 py-4">
                    <p class="text-gray-700 dark:text-gray-300" x-text="task.assignedUser"></p>
                </td>

                <td class="px-6 py-4">

                    <span
                        class="rounded-full px-3 py-1 text-xs font-medium"
                        :class="getPriorityClass(task.priority)"
                        x-text="task.priority"
                    ></span>

                </td>

                <td class="px-6 py-4">

                    <select
                        x-model="task.status"
                        class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                        :class="getStatusClass(task.status)"
                    >
                        <option>Pending</option>
                        <option>In Progress</option>
                        <option>Completed</option>
                    </select>

                </td>

                <td class="px-6 py-4">
                    <p class="text-gray-700 dark:text-gray-300" x-text="task.dueDate"></p>
                </td>

                <td class="px-6 py-4">

                    <button class="rounded-lg bg-gray-100 px-3 py-1 text-sm text-gray-700 hover:bg-gray-200">
                        Preview
                    </button>

                </td>

                <td class="px-6 py-4">

                    <div class="flex items-center gap-3">

                        <button class="text-blue-500 hover:text-blue-700">
                            Edit
                        </button>

                        <button class="text-red-500 hover:text-red-700">
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
<div class="flex items-center justify-between px-6 py-4">

    <button
    @click="prevPage"
    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
>
    Previous
</button>

   <p class="text-sm text-gray-500 dark:text-gray-400">
        Page <span x-text="currentPage"></span> of <span x-text="totalPages"></span>
    </p>

    <button
    @click="nextPage"
    class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
>
    Next
</button>

</div>

</div>

</x-common.component-card>

@endsection