<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { onMounted, onUnmounted } from 'vue';
import { useToast } from "vue-toastification";
import type { SharedData } from '@/types';

const toast = useToast();
const page = usePage<SharedData>()

defineProps({
    users: Object
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];

onMounted(() => {
    window.Echo.private(`chat.${page.props.auth.user.id}`)
    .listen("MessageSent", (response: any) => {
        const incomingMessage = response.chatMessage;
        toast.info(`${incomingMessage.sender.name}: ${incomingMessage.message}`);
    })
})

onUnmounted(() => {
    window.Echo.private(`chat.${page.props.auth.user.id}`).stopListening("MessageSent");
})
</script>

<template>
  <Head title="Users" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3 h-full rounded-xl p-4">
      <Link
        :href="route('chat', user)"
        v-for="user in users?.data"
        :key="user.id"
        class="border-sidebar-border/70 dark:border-sidebar-border relative flex aspect-video cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border"
      >
        <h3>{{ user.name }}</h3>
        <p>{{ user.email }}</p>
      </Link>
    </div>

    <Pagination class="mt-3" :links="users?.links" />
  </AppLayout>
</template>
