<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/components/Pagination.vue';

defineProps({
    users: Object
})

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
