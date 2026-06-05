
export const initChartThree = () => {
    const chartElement = document.querySelector('#taskCompleteTrend');

    if (chartElement) {
        const chartThreeOptions = {
            series: [{
                name: "High",
                data: window.dashboardData.taskCompletionTrend.high,
            },
            {
                name: "Medium",
                data: window.dashboardData.taskCompletionTrend.medium,
            },
            {
                name: "Low",
                data: window.dashboardData.taskCompletionTrend.low,
            },
            ],
            legend: {
                show: false,
                position: "top",
                horizontalAlign: "left",
            },
            colors: ["#213EFC", "#6593FF", "#9FBAFB"],
            chart: {
                fontFamily: "Outfit, sans-serif",
                height: 250,
                type: "area",
                toolbar: {
                    show: false,
                },
            },
            fill: {
                gradient: {
                    enabled: true,
                    opacityFrom: 0.55,
                    opacityTo: 0,
                },
            },
            stroke: {
                curve: "straight",
                width: ["2", "2", "2"],
            },
            markers: {
                size: 0,
            },
            labels: {
                show: false,
                position: "top",
            },
            grid: {
                padding: {
                    right: 20,
                    left: 10
                },
                xaxis: {
                    lines: {
                        show: false,
                    },
                },
                yaxis: {
                    lines: {
                        show: true,
                    },
                },
            },
            dataLabels: {
                enabled: false,
            },
            tooltip: {
                x: {
                    format: "dd MMM yyyy",
                },
            },
            xaxis: {
                type: "category",
                categories: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                tooltip: false,
            },
            yaxis: {
                title: {
                    style: {
                        fontSize: "0px",
                    },
                },
            },
        };

        //     const chart = new ApexCharts(chartElement, chartThreeOptions);
        //     chart.render();

        //     setTimeout(() => {
        //         window.dispatchEvent(new Event('resize'));
        //     }, 300);

        //     return chart;


        window.taskCompletionTrendChart = new ApexCharts(
            chartElement,
            chartThreeOptions
        );

        window.taskCompletionTrendChart.render();

        return window.taskCompletionTrendChart;
    }
}

export default initChartThree;
