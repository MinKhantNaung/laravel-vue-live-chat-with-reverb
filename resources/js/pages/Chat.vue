<script setup lang="ts">
import ChatComponent from '@/components/chat_page/ChatComponent.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps({
    user: {
        type: Object,
        required: true,
    },
    chatMessages: {
        type: Array as () => { id: number; sender_id: number; message: string; }[],
        required: true,
    },
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <ChatComponent :friend="user" :currentUser="$page.props.auth.user" :chatMessages="chatMessages" />
        </div>
    </AppLayout>
</template>
