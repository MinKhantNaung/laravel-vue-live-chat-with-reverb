import { defaultChartData, defaultChartOptions } from '../charts/messageLineChartConfig';
import { ref } from "vue";

export function useMessageLineChart() {
    const labels = ref<string[]>([]);
    const dataPoints = ref<number[]>([]);
    const maxPoints = 10;
    const messageCount = ref(0);

    const chartData = ref({ ...defaultChartData.value });
    const chartOptions = defaultChartOptions;

    const updateChart = () => {
        const now = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        if (labels.value.length >= maxPoints) {
            labels.value.shift();
            dataPoints.value.shift();
        }
        labels.value.push(now);
        dataPoints.value.push(messageCount.value);

        chartData.value = {
            labels: [...labels.value],
            datasets: [
                {
                    label: 'Messages Received Per Minute',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    data: [...dataPoints.value],
                    fill: true,
                    tension: 0.4,
                },
            ],
        };

        messageCount.value = 0;
    };

    // Push data into chart every minute
    const startChartInterval = () => {
        // Calculate milliseconds until the next minute starts
        const msUntilNextMinute = () => {
            const now = new Date();
            return (60 - now.getSeconds()) * 1000 - now.getMilliseconds();
        };

        setTimeout(() => {
            updateChart();

            setInterval(() => {
                updateChart();
            }, 60_000);
        }, msUntilNextMinute());
    }

    return {
        messageCount,
        chartData,
        chartOptions,
        startChartInterval,
    };
}
