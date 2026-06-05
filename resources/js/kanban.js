import Sortable from 'sortablejs';

window.kanbanBoard = (tasks) => ({
    lanes: [
        {
            id: 'pending',
            name: 'Pending',
            tasks: tasks.filter(t => t.status === 'pending')
        },
        {
            id: 'in_progress',
            name: 'In Progress',
            tasks: tasks.filter(t => t.status === 'in_progress')
        },
        {
            id: 'completed',
            name: 'Completed',
            tasks: tasks.filter(t => t.status === 'completed')
        }
    ],

    init() {

        this.$nextTick(() => {

        this.lanes.forEach(lane => {

            const el = document.getElementById(`lane-${lane.id}`);

            if (!el) {
                console.error(`Lane not found: lane-${lane.id}`);
                return;
            }

            new Sortable(el, {
                group: 'kanban',
                animation: 150,

                onEnd: (evt) => {
                    this.moveTask(evt);
                }
            });

        });

    });
    },

    async moveTask(evt) {

        const fromLaneId = evt.from.dataset.laneId;
        const toLaneId = evt.to.dataset.laneId;

        if (fromLaneId === toLaneId) return;

        const fromLane = this.lanes.find(l => l.id === fromLaneId);
        const toLane = this.lanes.find(l => l.id === toLaneId);

        const task = fromLane.tasks.splice(evt.oldIndex, 1)[0];

        const originalStatus = task.status;

        task.status = toLaneId;

        toLane.tasks.splice(evt.newIndex, 0, task);

        try {
            const response = await axios.patch(`/tasks/${task.id}/status`, {
                status: toLaneId
            });

            Alpine.store('toast').success(
                response.data.message || 'Task updated successfully'
            );

        } catch (error) {

            // rollback
            toLane.tasks.splice(evt.newIndex, 1);

            task.status = originalStatus;

            fromLane.tasks.splice(evt.oldIndex, 0, task);

            Alpine.store('toast').error(
                error.response?.data?.message || 'Failed to update task'
            );
        }
    }
});




// window.kanbanBoard = (tasks) => ({

//     draggedTaskId: null,
//     sourceLaneId: null,

//     lanes: [
//         {
//             id: 'pending',
//             name: 'Pending',
//             badgeClass: 'bg-yellow-100 text-yellow-700',
//             tasks: tasks.filter(task => task.status === 'pending')
//         },
//         {
//             id: 'in_progress',
//             name: 'In Progress',
//             badgeClass: 'bg-blue-100 text-blue-700',
//             tasks: tasks.filter(task => task.status === 'in_progress')
//         },
//         {
//             id: 'completed',
//             name: 'Completed',
//             badgeClass: 'bg-green-100 text-green-700',
//             tasks: tasks.filter(task => task.status === 'completed')
//         }
//     ],

//     handleDragStart(taskId, laneId) {
//         this.draggedTaskId = taskId;
//         this.sourceLaneId = laneId;
//     },

//     handleDragEnd() {
//         this.draggedTaskId = null;
//         this.sourceLaneId = null;
//     },


//     async handleDrop(event, targetLaneId) {

//         // console.log('DROP FIRED');
//         // console.log('Target Lane:', targetLaneId);

//         if (this.sourceLaneId === targetLaneId) {
//             return;
//         }

//         const sourceLane = this.lanes.find(
//             lane => lane.id === this.sourceLaneId
//         );

//         const targetLane = this.lanes.find(
//             lane => lane.id === targetLaneId
//         );

//         const taskIndex = sourceLane.tasks.findIndex(
//             task => task.id === this.draggedTaskId
//         );

//         if (taskIndex === -1) {
//             return;
//         }

//         const task = sourceLane.tasks.splice(taskIndex, 1)[0];

//         task.status = targetLaneId;

//         targetLane.tasks.push(task);

//         try {

//             const response = await fetch(`/tasks/${task.id}/status`, {

//                 method: 'PATCH',

//                 headers: {
//                     'Content-Type': 'application/json',

//                     'X-CSRF-TOKEN': document
//                         .querySelector('meta[name=csrf-token]')
//                         .getAttribute('content'),

//                     'Accept': 'application/json'
//                 },

//                 body: JSON.stringify({
//                     status: targetLaneId
//                 })
//             });

//             if (!response.ok) {
//                 throw new Error('Failed to update status');
//             }

//         } catch (error) {

//             console.error(error);

//             alert('Failed to update task status');
//         }

//         this.handleDragEnd();
//     }
// });
