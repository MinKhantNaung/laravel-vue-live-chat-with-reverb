<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { useOnlinePresenceStore } from '@/stores/onlinePresence';
import type { SharedData } from '@/types';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { onMounted, onUnmounted } from 'vue';
import { useToast } from 'vue-toastification';

defineProps({
    users: Object,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];

const toast = useToast();
const page = usePage<SharedData>();
const onlinePresenceStore = useOnlinePresenceStore();

onMounted(() => {
    window.Echo.private(`chat.${page.props.auth.user.id}`).listen('MessageSent', (response: any) => {
        const incomingMessage = response.chatMessage;
        toast.info(`${incomingMessage.sender.name}: ${incomingMessage.message}`);
    });

    onlinePresenceStore.joinPresence();
});

onUnmounted(() => {
    window.Echo.private(`chat.${page.props.auth?.user?.id}`).stopListening('MessageSent');
    onlinePresenceStore.leavePresence();
});
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="grid h-full auto-rows-min gap-4 rounded-xl p-4 md:grid-cols-3">
            <Link
                :href="route('chat', user)"
                v-for="user in users?.data"
                :key="user.id"
                class="border-sidebar-border/70 dark:border-sidebar-border relative flex aspect-video cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border"
            >
                <h3>{{ user.name }}</h3>
                <p>{{ user.email }}</p>
                <div class="absolute top-2 right-2 flex items-center gap-1 text-xs font-medium">
                    <span class="h-2 w-2 rounded-full" :class="onlinePresenceStore.onlineUserIds.has(user.id) ? 'bg-green-500' : 'bg-gray-400'" />
                    <span
                        :class="
                            onlinePresenceStore.onlineUserIds.has(user.id) ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'
                        "
                    >
                        {{ onlinePresenceStore.onlineUserIds.has(user.id) ? 'Online' : 'Offline' }}
                    </span>
                </div>
            </Link>
        </div>

        <Pagination class="mt-3" :links="users?.links" />
    </AppLayout>
</template>
