<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    friend?: object | null;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    friend: null
});
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" :friend="friend">
        <slot />
    </AppLayout>
</template>
