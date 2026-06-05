

export const initChartOne = () => {
    const chartElement = document.querySelector('#chartDistStatus');
    if (!chartElement) return;

    const chartOneOptions = {
        series: [{
            name: "Tasks",
            data: window.dashboardData.statusDistribution,
        },],
        colors: ["#465fff"],
        chart: {
            fontFamily: "Outfit, sans-serif",
            type: "bar",
            height: 250,
            width: "100%",
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "20%",
                borderRadius: 5,
                borderRadiusApplication: "end",
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            show: true,
            width: 4,
            colors: ["transparent"],
        },
        xaxis: {
            categories: [
                "Pending",
                "In progress",
                "Completed",
                "Overdue",
            ],
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
            markers: {
                radius: 99,
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

    // const chart = new ApexCharts(chartElement, chartOneOptions);
    // chart.render();


    // setTimeout(() => {
    //     window.dispatchEvent(new Event('resize'));
    // }, 300);

    // return chart;

    window.statusDistributionChart = new ApexCharts(
        chartElement,
        chartOneOptions
    );

    window.statusDistributionChart.render();

    return window.statusDistributionChart;
};

export default initChartOne;
