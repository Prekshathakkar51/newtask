 <!-- TOP CONTROLS -->

            {{-- <div class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between text-sm"> --}}

                <!-- SEARCH -->
                {{-- <div class="w-full md:max-w-sm"> --}}
                    <div class="px-6 py-4">

                        <input type="text" type="text" x-model="search" @input.debounce.500ms="fetchTasks()"
                            value="{{ request('search') }}" placeholder="Search by taskname or username here..."
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none focus:border-brand-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">

                    </div>
                    {{--
                </div> --}}


                {{-- <div class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between text-sm">
                    <div class="w-full md:max-w-sm"> --}}

                        <div class="px-6 pb-4">
                            <div @date-change.window="handleDateRange($event)">
                                <x-form.date-picker mode="range" placeholder="Select date range" />
                            </div>


                            <input type="checkbox" x-model="dueToday" @change="fetchTasks()" />
                            <label>Due Today</label>

                            <input type="checkbox" x-model="overdue" @change="fetchTasks()" />
                            <label>Overdue</label>

                            {{-- <input type="checkbox" x-model="dueToday" @change="fetchTasks()" class="sr-only" />

                            <div
                                :class="dueToday ? 'border-brand-500 bg-brand-500': 'bg-transparent border-gray-300 dark:border-gray-700'">
                                Due Today</div>

                            <input type="checkbox" x-model="overdue" @change="fetchTasks()" class="sr-only" />

                            <div
                                :class="overdue ? 'border-brand-500 bg-brand-500': 'bg-transparent border-gray-300 dark:border-gray-700'">
                                Overdue</div> --}}

                        </div>
                        {{--
                    </div> --}}



                    {{-- <div class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between text-sm">
                        --}}


                        <!-- FILTER + SORT -->
                        {{-- <div class="flex flex-col gap-3 sm:flex-row"> --}}

                            <!-- FILTER -->


                            {{-- <input type="date" x-model="fromDate" @change="fetchTasks()"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm">

                            <input type="date" x-model="toDate" @change="fetchTasks()"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm"> --}}

                            <select x-model="userId" @change="fetchTasks()"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">

                                <option value="">
                                    Select Users
                                </option>

                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach

                            </select>

                            <select x-model="status" @change="fetchTasks()"
                                class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 outline-none dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                                <option value="">Select Status</option>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress
                                </option>
                                <option value="completed">Completed
                                </option>
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
                                <option value="created_date">Created
                                    Date</option>
                            </select>



                        </div>

                    </div>




                    {{-- <div class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between text-sm">
                        <div class="w-full md:max-w-sm"> --}}

                            {{-- <div class="flex flex-wrap items-center gap-8">
                                <div x-data="{ checkboxToggle: false }">
                                    <label for="checkboxLabelOne"
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <div class="relative">
                                            <input type="checkbox" x-model="dueToday" @change="fetchTasks()"
                                                id="checkboxLabelOne" class="sr-only"
                                                @change="checkboxToggle = !checkboxToggle" />
                                            <div :class="checkboxToggle ? 'border-brand-500 bg-brand-500' :
                                                        'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="f hover:border-brand-500 dark:hover:border-brand-500 mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                                <span :class="checkboxToggle ? '' : 'opacity-0'">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="white"
                                                            stroke-width="1.94437" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        Due Today
                                    </label>
                                </div>

                                <div x-data="{ checkboxToggle: false }">
                                    <label for="checkboxLabelOne"
                                        class="flex cursor-pointer items-center text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                                        <div class="relative">
                                            <input type="checkbox" x-model="overdue" @change="fetchTasks()"
                                                id="checkboxLabelOne" class="sr-only"
                                                @change="checkboxToggle = !checkboxToggle" />
                                            <div :class="checkboxToggle ? 'border-brand-500 bg-brand-500' :
                                                        'bg-transparent border-gray-300 dark:border-gray-700'"
                                                class="f hover:border-brand-500 dark:hover:border-brand-500 mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]">
                                                <span :class="checkboxToggle ? '' : 'opacity-0'">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="white"
                                                            stroke-width="1.94437" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        Overdue
                                    </label>
                                </div> --}}


                                {{-- <input type="checkbox" x-model="dueToday" @change="fetchTasks()" />
                                <label>Due Today</label>

                                <input type="checkbox" x-model="overdue" @change="fetchTasks()" />
                                <label>Overdue</label> --}}
                                {{--
                            </div>

                        </div> --}}

                        {{-- <div class="flex flex-col gap-4 px-6 py-4 md:flex-row md:items-center md:justify-between text-sm">
                            <div class="w-full md:max-w-sm"> --}}


                                {{-- <div class="flex items-center gap-5"> --}}
                                    <x-ui.button @click="exportTasks('csv')" size="sm" variant="primary">Export
                                        CSV</x-ui.button>
                                    <x-ui.button @click="exportTasks('xlsx')" size="sm" variant="primary">Export
                                        Excel</x-ui.button>
                                    {{--
                                </div> --}}
                                {{-- <button @click="exportTasks('csv')"
                                    class="mb-5 mt-5 bg-brand-500 hover:bg-brand-600 shadow-theme-xs inline-flex h-11 w-full items-center justify-center rounded-lg px-6 py-3 text-sm font-medium text-white transition">
                                    Export CSV
                                </button>

                                <button @click="exportTasks('xlsx')"
                                    class="bg-brand-500 hover:bg-brand-600 shadow-theme-xs inline-flex h-11 w-full items-center justify-center rounded-lg px-6 py-3 text-sm font-medium text-white transition">
                                    Export Excel
                                </button> --}}
                            {{-- </div>
                        </div> --}}


                        {{-- <button @click="fetchTasks()" class="rounded-lg bg-blue-500 px-4 py-2 text-white">
                            Test Ajax
                        </button> --}}
