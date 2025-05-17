<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { SharedData, type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import type { ChartData } from 'chart.js';
import { CategoryScale, Chart as ChartJS, Filler, Legend, LinearScale, LineElement, PointElement, Title, Tooltip } from 'chart.js';
import { onMounted, onUnmounted, ref } from 'vue';
import { Line } from 'vue-chartjs';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, Filler);

const page = usePage<SharedData>();
const currentUser = ref(page.props.auth.user);

const labels = ref<string[]>([]);
const dataPoints = ref<number[]>([]);
const chartRef = ref(null);
const maxPoints = 10;
const messageCount = ref(0);

const chartData = ref<ChartData<'line'>>({
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

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        y: {
            beginAtZero: true,
            stepSize: 1,
        },
    },
};

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

// Calculate milliseconds until the next minute starts
function msUntilNextMinute() {
    const now = new Date();
    return (60 - now.getSeconds()) * 1000 - now.getMilliseconds();
}

// Push data into chart every minute
setTimeout(() => {
    updateChart();

    setInterval(() => {
        updateChart();
    }, 60_000)
}, msUntilNextMinute());

onMounted(() => {
    if (!currentUser.value) return;

    window.Echo.private(`chat.${currentUser.value.id}`).listen('MessageSent', () => {
        messageCount.value++;
    });
});

onUnmounted(() => {
    window.Echo.private(`chat.${currentUser.value.id}`).stopListening('MessageSent');
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="h-64">
            <Line ref="chartRef" :data="chartData" :options="chartOptions" />
        </div>
    </AppLayout>
</template>
