

export function initChartSix() {
    const chartSixEl = document.querySelector('#priorityChart');
    if (chartSixEl) {
        const chartSixOptions = {
            series: [
                {
                    name: "Pending",
                    data: window.dashboardData.priorityChartData.pending,
                },
                {
                    name: "In Progress",
                    data: window.dashboardData.priorityChartData.in_progress,
                },
                {
                    name: "Completed",
                    data: window.dashboardData.priorityChartData.completed,
                },

            ],
            colors: ["#2a31d8", "#7592ff", "#c2d6ff"],
            chart: {
                fontFamily: "Outfit, sans-serif",
                type: "bar",
                stacked: true,
                height: 250,
                toolbar: {
                    show: false,
                },
                zoom: {
                    enabled: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "20%",
                    borderRadius: 10,
                    borderRadiusApplication: "end",
                    borderRadiusWhenStacked: "last",
                },
            },
            dataLabels: {
                enabled: false,
            },
            xaxis: {
                categories: ["High", "Medium", "Low"],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            legend: {
                show: true,
                position: "top",
                horizontalAlign: "left",
                fontFamily: "Outfit",
                fontSize: "14px",
                fontWeight: 400,
                markers: {
                    size: 5,
                    shape: "circle",
                    radius: 999,
                    strokeWidth: 0,
                },
                itemMargin: {
                    horizontal: 10,
                    vertical: 0,
                },
            },
            yaxis: {
                title: false,
            },
            grid: {
                padding: {
                    right: 20,
                    left: 10
                },
                yaxis: {
                    lines: {
                        show: true,
                    },
                },
            },
            fill: {
                opacity: 1,
            },

            tooltip: {
                x: {
                    show: false,
                },
                y: {
                    formatter: function (val) {
                        return val;
                    },
                },
            },
        };

        //     const chartSix = new ApexCharts(chartSixEl, chartSixOptions);
        //     chartSix.render();
        //     setTimeout(() => {
        //     window.dispatchEvent(new Event('resize'));
        // }, 300);

        //     return chartSix;
       

        window.priorityChart = new ApexCharts(
            chartSixEl,
            chartSixOptions
        );

        window.priorityChart.render();

        return window.priorityChart;
    }
}