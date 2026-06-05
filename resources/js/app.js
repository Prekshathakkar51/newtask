import './bootstrap';
import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

import Sortable from 'sortablejs';

// flatpickr
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
// FullCalendar
import { Calendar } from '@fullcalendar/core';

import './kanban';

import './register-validation';
import './login-validation';
import './task-validation';







window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.flatpickr = flatpickr;
window.FullCalendar = Calendar;




Alpine.store('toast', {
    show: false,
    title: '',
    message: '',
    type: 'success',
    timeout: null,

    success(message) {
        this.type = 'success';
        this.showToast('Success', message);
    },

    error(message) {
        this.type = 'error';
        this.showToast('Error', message);
    },

    info(message) {
        this.type = 'info';
        this.showToast('Info', message);
    },

    warning(message) {
        this.type = 'warning';
        this.showToast('Warning', message);
    },

    showToast(title, message) {
        this.title = title;
        this.message = message;
        this.show = true;

        clearTimeout(this.timeout);

        this.timeout = setTimeout(() => {
            this.show = false;
        }, 3000);
    },

    hide() {
        this.show = false;
    }
});

Alpine.start();

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Map imports
    if (document.querySelector('#mapOne')) {
        import('./components/map').then(module => module.initMap());
    }

    // Chart imports
    if (document.querySelector('#chartOne')) {
        import('./components/chart/chart-1').then(module => module.initChartOne());
    }
    if (document.querySelector('#chartTwo')) {
        import('./components/chart/chart-2').then(module => module.initChartTwo());
    }
    if (document.querySelector('#chartThree')) {
        import('./components/chart/chart-3').then(module => module.initChartThree());
    }
    if (document.querySelector('#chartSix')) {
        import('./components/chart/chart-6').then(module => module.initChartSix());
    }
    if (document.querySelector('#chartEight')) {
        import('./components/chart/chart-8').then(module => module.initChartEight());
    }
    if (document.querySelector('#chartThirteen')) {
        import('./components/chart/chart-13').then(module => module.initChartThirteen());
    }



    if (document.querySelector('#chartDistStatus')) {
        import('./components/chart/taskDistStatus').then(module => module.initChartOne());
    }

     if (document.querySelector('#monthlyChartCreation')) {
        import('./components/chart/monthlyChartCreation').then(module => module.initChartOne());
    }

    if (document.querySelector('#priorityChart')) {
        import('./components/chart/priorityChart').then(module => module.initChartSix());
    }

    if (document.querySelector('#taskCompleteTrend')) {
        import('./components/chart/taskCompleteTrend').then(module => module.initChartThree());
    }

    

    // Calendar init
    if (document.querySelector('#calendar')) {
        import('./components/calendar-init').then(module => module.calendarInit());
    }
});
