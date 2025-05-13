<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Deferred, Head, Link } from '@inertiajs/vue3';

defineProps<{ users: { id: number; name: string; email: string }[] }>();

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
      <Deferred data="users">
        <template #fallback>
          <div>Loading...</div>
        </template>

        <Link
          :href="route('chat', user)"
          v-for="user in users"
          :key="user.id"
          class="border-sidebar-border/70 dark:border-sidebar-border relative flex aspect-video cursor-pointer flex-col items-center justify-center overflow-hidden rounded-xl border"
        >
          <h3>{{ user.name }}</h3>
          <p>{{ user.email }}</p>
        </Link>
      </Deferred>
    </div>
  </AppLayout>
</template>
