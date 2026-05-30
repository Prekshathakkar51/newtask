@extends('layouts.app')

@section('content')

  <x-common.page-breadcrumb pageTitle="Create Task" />


  <x-common.component-card title="Create Your Task Here">

    {{-- <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6"> --}}

        @csrf


    <!-- Task Title -->
    <div>
      <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Task Title
      </label>
      <input type="text" placeholder="Enter task title"
        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
    </div>

    <!-- Task Description -->
    <div>
      <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Task Description
      </label>
      <textarea placeholder="Enter task description..." type="text" rows="3"
        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"></textarea>
    </div>

    <!-- Task User Select -->



 <div
    x-data="{
        open: false,
        search: '',
        selected: 'Select User',
        selectedId: '',

        users: [
            { id: 1, name: 'John Doe' },
            { id: 2, name: 'Merry Morris' },
            { id: 3, name: 'Sam Samuel' },
            { id: 4, name: 'Harry Potter' },
            { id: 5, name: 'Jane Smith' },
        ],

        get filteredUsers() {
            return this.users.filter(user =>
                user.name.toLowerCase().includes(this.search.toLowerCase())
            )
        },

        selectUser(user) {
            this.selected = user.name
            this.selectedId = user.id
            this.open = false
            this.search = ''
        }
    }"
    class="relative w-full"
    @click.away="open = false"
>
    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Select User
    </label>

    <!-- Hidden Input -->
    <input type="hidden" name="user_id" :value="selectedId">

    <!-- Selected Value -->
    <div
        @click="open = !open"
        class="dark:bg-dark-900 shadow-theme-xs focus-within:border-brand-300 focus-within:ring-brand-500/10 dark:focus-within:border-brand-800 flex h-11 w-full cursor-pointer items-center justify-between rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90"
    >
        <span x-text="selected"></span>

        <svg
            class="h-5 w-5 text-gray-500 transition-transform"
            :class="{ 'rotate-180': open }"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7"></path>
        </svg>
    </div>

    <!-- Dropdown -->
    <div
        x-show="open"
        x-transition
        class="absolute z-50 mt-2 w-full rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-900"
    >

        <!-- Search Box -->
        <div class="p-3 border-b border-gray-200 dark:border-gray-700">
            <input
                type="text"
                x-model="search"
                placeholder="Search user..."
                class="h-10 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-800 focus:border-brand-300 focus:outline-none dark:border-gray-700 dark:bg-gray-800 dark:text-white"
            >
        </div>

        <!-- Options -->
        <div class="max-h-60 overflow-y-auto py-2">
            <template x-if="filteredUsers.length === 0">
                <div class="px-4 py-3 text-sm text-gray-500">
                    No user found
                </div>
            </template>

            <template x-for="user in filteredUsers" :key="user.id">
                <div
                    @click="selectUser(user)"
                    class="cursor-pointer px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
                    x-text="user.name"
                ></div>
            </template>
        </div>
    </div>
</div>


    {{-- <div>
      <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Task User
      </label>
      <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
        <select
          class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
          :class="isOptionSelected && 'text-gray-800 dark:text-white/90'" @change="isOptionSelected = true">
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            Select Task User
          </option>
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            John Doe
          </option>
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            Sarah Smith
          </option>
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            Michael Johnson
          </option>
        </select>
        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
          <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </span>
      </div>
    </div> --}}


    <!-- Task Priority Select -->
    <div>
      <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Task Priority
      </label>
      <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
        <select
          class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
          :class="isOptionSelected && 'text-gray-800 dark:text-white/90'" @change="isOptionSelected = true">
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            Select Task Priority
          </option>
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            Low
          </option>
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            Medium
          </option>
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            High
          </option>
        </select>
        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
          <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </span>
      </div>
    </div>



    <!-- Task Priority Select -->
    <div>
      <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Task Status
      </label>
      <div x-data="{ isOptionSelected: false }" class="relative z-20 bg-transparent">
        <select
          class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
          :class="isOptionSelected && 'text-gray-800 dark:text-white/90'" @change="isOptionSelected = true">
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            Select Task Status
          </option>
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            Pending
          </option>
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            In Progress
          </option>
          <option value="" class="text-gray-700 dark:bg-gray-900 dark:text-gray-400">
            Completed
          </option>
        </select>
        <span class="pointer-events-none absolute top-1/2 right-4 z-30 -translate-y-1/2 text-gray-500 dark:text-gray-400">
          <svg class="stroke-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M4.79175 7.396L10.0001 12.6043L15.2084 7.396" stroke="" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </span>
      </div>
    </div>


    <!-- Due Date -->
    <div>
      <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Due Date
      </label>

      <x-form.date-picker id="date_pick" name="date_pick" placeholder="Date Picker"
        defaultDate="{{ now()->format('Y-m-d') }}" />
    </div>

    <!-- File Upload -->

    <div>
      <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
        Upload Task Related File (PDF, DOC / DOCX, Images, ZIP files)
      </label>
      <input type="file"
        class="focus:border-ring-brand-300 shadow-theme-xs focus:file:ring-brand-300 h-11 w-full overflow-hidden rounded-lg border border-gray-300 bg-transparent text-sm text-gray-500 transition-colors file:mr-5 file:border-collapse file:cursor-pointer file:rounded-l-lg file:border-0 file:border-r file:border-solid file:border-gray-200 file:bg-gray-50 file:py-3 file:pr-3 file:pl-3.5 file:text-sm file:text-gray-700 placeholder:text-gray-400 hover:file:bg-gray-100 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-gray-400 dark:text-white/90 dark:file:border-gray-800 dark:file:bg-white/[0.03] dark:file:text-gray-400 dark:placeholder:text-gray-400" />
    </div>


    <div class="pt-2">
            <button
                type="submit"
                class="bg-brand-500 hover:bg-brand-600 shadow-theme-xs inline-flex h-11 w-full items-center justify-center rounded-lg px-6 py-3 text-sm font-medium text-white transition"
            >
                Create Task
            </button>
        </div>

    </form>


  </x-common.component-card>


@endsection



