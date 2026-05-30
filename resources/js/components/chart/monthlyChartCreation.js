

export const initChartOne = () => {
    const chartElement = document.querySelector('#monthlyChartCreation');
    if (!chartElement) return;

    const chartOneOptions = {
        series: [{
            name: "Sales",
            data: [168, 385, 201, 298, 187, 195, 291, 110, 215, 390, 280, 112],
        },],
        colors: ["#465fff"],
        chart: {
            fontFamily: "Outfit, sans-serif",
            type: "bar",
            height: 250,
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

    const chart = new ApexCharts(chartElement, chartOneOptions);
    chart.render();

    setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
    }, 300);

    return chart;
};

export default initChartOne;
