<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';
import { onMounted, onUnmounted, ref } from 'vue';
import { useToast } from "vue-toastification";
import type { SharedData } from '@/types';

const toast = useToast();
const page = usePage<SharedData>()

defineProps({
    users: Object
});

const onlineUserIds = ref(new Set<number>());

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

    window.Echo.join('online-users')
        .here((users: { id: number }[]) => {
            onlineUserIds.value = new Set(users.map(u => u.id));
        })
        .joining((user: { id: number }) => {
            onlineUserIds.value.add(user.id);
            console.log(onlineUserIds.value)
        })
        .leaving((user: { id: number }) => {
            onlineUserIds.value.delete(user.id);
            console.log(onlineUserIds.value)
        });
})

onUnmounted(() => {
    window.Echo.private(`chat.${page.props.auth?.user?.id}`).stopListening("MessageSent");
    window.Echo.leave('online-users');
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
        <span
          class="absolute top-2 right-2 h-3 w-3 rounded-full"
          :class="onlineUserIds.has(user.id) ? 'bg-green-500' : 'bg-gray-400'"
          title="Status"
        />
      </Link>
    </div>

    <Pagination class="mt-3" :links="users?.links" />
  </AppLayout>
</template>
