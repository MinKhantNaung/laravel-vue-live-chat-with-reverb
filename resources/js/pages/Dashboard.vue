<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useOnlinePresenceStore } from '@/stores/onlinePresence';
import { SharedData, type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { CategoryScale, Chart as ChartJS, Filler, Legend, LinearScale, LineElement, PointElement, Title, Tooltip } from 'chart.js';
import { onMounted, onUnmounted, ref } from 'vue';
import { Line } from 'vue-chartjs';
import { useMessageLineChart } from './composables/MessageLineChart';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale, PointElement, Filler);

const { messageCount, chartData, chartOptions, startChartInterval } = useMessageLineChart();

const page = usePage<SharedData>();
const onlinePresenceStore = useOnlinePresenceStore();
const currentUser = ref(page.props.auth.user);

onMounted(() => {
    startChartInterval();

    if (!currentUser.value) return;

    window.Echo.private(`chat.${currentUser.value.id}`).listen('MessageSent', () => {
        messageCount.value++;
    });

    onlinePresenceStore.joinPresence();
});

onUnmounted(() => {
    window.Echo.private(`chat.${currentUser.value.id}`).stopListening('MessageSent');
    onlinePresenceStore.leavePresence();
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-4">
            <!-- Info Message -->
            <div
                class="rounded-md border border-blue-200 bg-blue-50 p-3 text-sm text-blue-800 dark:border-blue-700 dark:bg-blue-900 dark:text-blue-100"
            >
                This chart displays the number of messages received per minute. It updates automatically every minute.
            </div>

            <div class="h-64">
                <Line :data="chartData" :options="chartOptions" />
            </div>
        </div>
    </AppLayout>
</template>
