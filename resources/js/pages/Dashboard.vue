<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

defineProps({ users: Array });

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
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    v-for="user in users"
                    :key="user.id"
                    class="border-sidebar-border/70 dark:border-sidebar-border relative flex aspect-video flex-col items-center justify-center overflow-hidden rounded-xl border"
                >
                    <h3>{{ user.name }}</h3>
                    <p>{{ user.email }}</p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
