<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItemType, User } from '@/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    friend?: User | null;
    onlineUserIds?: Set<number>;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
    friend: null,
    onlineUserIds: () => new Set<number>(),
});
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" :friend="friend" :onlineUserIds="onlineUserIds" />
            <slot />
        </AppContent>
    </AppShell>
</template>
