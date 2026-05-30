export default () => ({
    draggingTaskId: null,
    draggedFromLaneId: null,

    lanes: [
        {
            id: 'todo',
            name: 'To Do',
            badgeClass: 'bg-gray-100 text-gray-700 dark:bg-white/[0.03] dark:text-white/80',
            tasks: [
                {
                    id: 1,
                    title: 'Setup Laravel Project',
                    date: 'Today',
                    comments: 2,
                    user: 'https://i.pravatar.cc/40?img=1',
                    category: 'Backend',
                    categoryClass: 'bg-brand-50 text-brand-500 dark:bg-brand-500/15 dark:text-brand-400'
                },
                {
                    id: 2,
                    title: 'Design Login Page',
                    date: 'Tomorrow',
                    comments: 1,
                    user: 'https://i.pravatar.cc/40?img=2',
                    category: 'UI',
                    categoryClass: 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500'
                }
            ]
        },

        {
            id: 'in-progress',
            name: 'In Progress',
            badgeClass: 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 text-orange-400',
            tasks: [
                {
                    id: 3,
                    title: 'Build Kanban UI',
                    date: 'Today',
                    comments: 4,
                    user: 'https://i.pravatar.cc/40?img=3',
                    category: 'Frontend',
                    categoryClass: 'bg-orange-400/10 text-orange-400'
                }
            ]
        },

        {
            id: 'completed',
            name: 'Completed',
            badgeClass: 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-500',
            tasks: [
                {
                    id: 4,
                    title: 'Install TailAdmin',
                    date: 'Yesterday',
                    comments: 5,
                    user: 'https://i.pravatar.cc/40?img=4',
                    category: 'Setup',
                    categoryClass: 'bg-gray-100 text-gray-700 dark:bg-white/[0.03] dark:text-white/80'
                }
            ]
        }
    ],

    handleDragStart(event, taskId, laneId) {
        this.draggingTaskId = taskId;
        this.draggedFromLaneId = laneId;

        event.currentTarget.classList.add('opacity-50');
    },

    handleDragEnd(event) {
        event.currentTarget.classList.remove('opacity-50');
    },

    handleDrop(event, laneId) {
        event.preventDefault();

        const fromLane = this.lanes.find(l => l.id === this.draggedFromLaneId);
        const toLane = this.lanes.find(l => l.id === laneId);

        if (!fromLane || !toLane) return;

        const taskIndex = fromLane.tasks.findIndex(
            t => t.id === this.draggingTaskId
        );

        if (taskIndex === -1) return;

        const task = fromLane.tasks.splice(taskIndex, 1)[0];

        toLane.tasks.push(task);

        this.draggingTaskId = null;
        this.draggedFromLaneId = null;
    }
});
