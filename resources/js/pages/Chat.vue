<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import ChatComponent from '@/pages/components/ChatComponent.vue';
import { useOnlinePresenceStore } from '@/stores/onlinePresence';
import type { BreadcrumbItem, SharedData, User } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';

const page = usePage<SharedData>();

defineProps<{
    user: User;
    chatMessages: { id: number; sender_id: number; message: string }[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const onlinePrescenceStore = useOnlinePresenceStore();

onMounted(() => onlinePrescenceStore.joinPresence());
onUnmounted(() => onlinePrescenceStore.leavePresence());
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs" :friend="user" :onlineUserIds="onlinePrescenceStore.onlineUserIds">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <ChatComponent :friend="user" :currentUser="page.props.auth.user" :chatMessages="chatMessages" />
        </div>
    </AppLayout>
</template>
