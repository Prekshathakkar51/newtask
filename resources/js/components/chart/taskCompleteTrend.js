
export const initChartThree = () => {
    const chartElement = document.querySelector('#taskCompleteTrend');

    if (chartElement) {
        const chartThreeOptions = {
            series: [{
                name: "High",
                data: [180, 190, 170, 160, 175, 165, 170],
            },
            {
                name: "Medium",
                data: [40, 30, 50, 40, 55, 40, 70],
            },
            {
                name: "Low",
                data: [20, 40, 70, 140, 75, 140, 79],
            },
            ],
            legend: {
                show: false,
                position: "top",
                horizontalAlign: "left",
            },
            colors: ["#213EFC","#6593FF" ,  "#9FBAFB"],
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
                width: ["2", "2" , "2"],
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
                    "Mon",
                    "Tue",
                    "Wed",
                    "Thu",
                    "Fri",
                    "Sat",
                    "Sun",
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

        const chart = new ApexCharts(chartElement, chartThreeOptions);
        chart.render();

        setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
    }, 300);

        return chart;
    }
}

export default initChartThree;
