@extends('layouts.app')

@section('content')

<div class="mb-6">

  <div class="flex items-center gap-3">
            <button class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                <svg class="stroke-current fill-white dark:fill-gray-800" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z" fill="" stroke="" stroke-width="1.5" />
                    <path d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z" fill="" stroke="" stroke-width="1.5" />
                </svg>
                Filter
            </button>

            <button class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-theme-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] dark:hover:text-gray-200">
                See all
            </button>
        </div>
      </div>


  <div class="grid grid-cols-12 gap-4 md:gap-6">




    <div class="col-span-12 ">
      <x-ecommerce.ecommerce-metrics />
      {{-- <x-ecommerce.monthly-sale /> --}}
    </div>
    {{-- <div class="col-span-12 xl:col-span-5">
      <x-ecommerce.monthly-target />
    </div> --}}

    <div class="col-span-12">
      {{-- <x-ecommerce.statistics-chart /> --}}

      <x-common.component-card title="Task Distribution Status">
        <!-- ====== Bar Chart One Start -->
        <div class="overflow-hidden w-full h-[250px]">
          <div id="chartDistStatus"></div>
        </div>
        <!-- ====== Bar Chart One End -->
      </x-common.component-card>
    </div>

    <div class="col-span-12">
      {{-- <x-ecommerce.statistics-chart /> --}}

      <x-common.component-card title="Monthly Task Creation">
        <!-- ====== Bar Chart One Start -->
        <div class="overflow-hidden w-full h-[250px]">
          <div id="monthlyChartCreation"></div>
        </div>
        <!-- ====== Bar Chart One End -->
      </x-common.component-card>
    </div>


    <div class="col-span-12">
      <x-common.component-card title="Task Completion Trend">
        <!-- ====== Line Chart One Start -->
        <div class="custom-scrollbar max-w-full overflow-x-auto">
          <div id="taskCompleteTrend" class="min-w-[1000px]"></div>
        </div>
        <!-- ====== Line Chart One End -->
      </x-common.component-card>
    </div>

    <div class="col-span-12">
      {{-- <x-ecommerce.statistics-chart /> --}}

      <x-common.component-card title="Priority Wise Task Count">
        <!-- ====== Bar Chart One Start -->
        <div class="overflow-hidden w-full h-[250px]">
          <div id="priorityChart"></div>
        </div>
        <!-- ====== Bar Chart One End -->
      </x-common.component-card>
    </div>

    {{-- <div class="col-span-12 xl:col-span-5">
      <x-ecommerce.customer-demographic />
    </div> --}}

    {{-- <div class="col-span-12 xl:col-span-7">
      <x-ecommerce.recent-orders />
    </div> --}}
  </div>
@endsection