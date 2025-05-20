import { ChartData } from "chart.js";
import { ref } from "vue";

export const defaultChartData = ref<ChartData<'line'>>({
    labels: [],
    datasets: [
        {
            label: 'Messages Received Per Minute',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            data: [],
            fill: true,
            tension: 0.4,
        },
    ],
});

export const defaultChartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        y: {
            beginAtZero: true,
            stepSize: 1,
        },
    },
};
