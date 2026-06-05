@extends('layouts.app')

@section('content')

  <div x-data="{
          userId: '',
          status: '',
          fromDate: '',
          toDate: '',

          dashboardData: {
        totalTasks: @js($totalTasks),
        pendingTasks: @js($pendingTasks),
        inProgressTasks: @js($inProgressTasks),
        completedTasks: @js($completedTasks),
        overdueTasks: @js($overdueTasks),
        totalTeamMembers: @js($totalTeamMembers),
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

              this.fetchDashboard();
          },

          async fetchDashboard() {

      try {


          const response = await axios.get(
              '/dashboard/filter',
              {
                  params: {
                      user_id: this.userId,
                      status: this.status,
                      from_date: this.fromDate,
                      to_date: this.toDate,
                  }
              }
          );

          this.dashboardData = {
    totalTasks: response.data.totalTasks,
    pendingTasks: response.data.pendingTasks,
    inProgressTasks: response.data.inProgressTasks,
    completedTasks: response.data.completedTasks,
    overdueTasks: response.data.overdueTasks,
    totalTeamMembers: response.data.totalTeamMembers,
};

          window.statusDistributionChart.updateSeries([
      {
          name: 'Tasks',
          data: response.data.statusDistribution
      }
      ]);

      window.monthlyTaskCreationChart.updateSeries([
      {
          name: 'Tasks',
          data: response.data.monthlyTaskCreationData
      }
  ]);

  window.priorityChart.updateSeries([
      {
          name: 'Pending',
          data: response.data.priorityChartData.pending
      },
      {
          name: 'In Progress',
          data: response.data.priorityChartData.in_progress
      },
      {
          name: 'Completed',
          data: response.data.priorityChartData.completed
      }
  ]);

  window.taskCompletionTrendChart.updateSeries([
    {
        name: 'High',
        data: response.data.taskCompletionTrend.high
    },
    {
        name: 'Medium',
        data: response.data.taskCompletionTrend.medium
    },
    {
        name: 'Low',
        data: response.data.taskCompletionTrend.low
    }
]);


      } catch (error) {

          console.error(error);

      }

  },
      }">

    <div class="flex flex-wrap gap-6 mb-6">

      <div @date-change.window="handleDateRange($event)">
        <x-form.date-picker mode="range" placeholder="Task Creation Date Range" />
      </div>

      <select x-model="userId" @change="fetchDashboard()" {{-- @change="console.log('User:', userId)" --}}
        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800   rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                >

        <option value="">Select User</option>

        @foreach($users as $user)
          <option value="{{ $user->id }}">
            {{ $user->name }}
          </option>
        @endforeach

      </select>

      <select x-model="status" @change="fetchDashboard()" {{-- @change="console.log('Status:', status)" --}}
        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800   rounded-lg border border-gray-300 bg-transparent bg-none px-4 py-2.5 pr-11 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30"
                >

        <option value="">Select Status</option>
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>

      </select>

    </div>

    


    <div class="grid grid-cols-12 gap-4 md:gap-6">




      <div class="col-span-12 ">
        <x-ecommerce.ecommerce-metrics :totalTasks="$totalTasks" :pendingTasks="$pendingTasks"
          :inProgressTasks="$inProgressTasks" :completedTasks="$completedTasks" :overdueTasks="$overdueTasks"
          :totalTeamMembers="$totalTeamMembers" />

      </div>

      <div class="col-span-12">


        <x-common.component-card title="Task Distribution Status">
          <!-- ====== Bar Chart One Start -->
          <div class="overflow-hidden w-full h-[250px]">
            <div id="chartDistStatus"></div>
          </div>
          <!-- ====== Bar Chart One End -->
        </x-common.component-card>
      </div>

      <div class="col-span-12">


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


    </div>


    @push('scripts')

      <script>

        window.dashboardData = {

          statusDistribution: @json($statusDistribution),
          priorityChartData: @json($priorityChartData),
          monthlyTaskCreation: @json($monthlyTaskCreationData),
          taskCompletionTrend: @json($taskCompletionTrend),



        };

      </script>

    @endpush

  </div>
@endsection