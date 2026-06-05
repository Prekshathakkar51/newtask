@props([
  'totalTasks',
  'pendingTasks',
  'inProgressTasks',
  'completedTasks',
  'overdueTasks',
  'totalTeamMembers',
])

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 gap-4 sm:grid-cols-3 md:gap-6">
  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
    

    <div class="flex items-center justify-center mt-5">
      <div class="text-center">
        <span class="text-sm  text-gray-500 dark:text-gray-400">Total Tasks</span>
        <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
          <span x-text="dashboardData.totalTasks"></span>
        </h4>
  </div>

    </div>
  </div>


  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
    

    <div class="flex items-center justify-center mt-5">
<div class="text-center">
        <span class="text-sm text-gray-500 dark:text-gray-400">Pending Tasks</span>
        <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
          <span x-text="dashboardData.pendingTasks"></span>
        </h4>
      </div>

      
    </div>


  </div>



  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">

    <div class="flex items-center justify-center mt-5">
      <div class="text-center">
        <span class="text-sm text-gray-500 dark:text-gray-400">In Progress Tasks</span>
        <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
          <span x-text="dashboardData.inProgressTasks"></span>
        </h4>
      </div>
    </div>
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">

    <div class="flex items-center justify-center mt-5">
      <div class="text-center">
        <span class="text-sm text-gray-500 dark:text-gray-400">Completed Tasks</span>
        <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
          <span x-text="dashboardData.completedTasks"></span>
        </h4>
      </div>
    </div>
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">

    <div class="flex items-center justify-center mt-5">
      <div class="text-center">
        <span class="text-sm text-gray-500 dark:text-gray-400">Overdue Tasks</span>
        <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
          <span x-text="dashboardData.overdueTasks"></span>
        </h4>
      </div>
    </div>
  </div>

  <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">

    <div class="flex items-center justify-center mt-5">
      <div class="text-center">
        <span class="text-sm text-gray-500 dark:text-gray-400">Total Team Members</span>
        <h4 class="mt-2 font-bold text-gray-800 text-title-sm dark:text-white/90">
          <span x-text="dashboardData.totalTeamMembers"></span>
        </h4>
      </div>
    </div>
  </div>


</div>