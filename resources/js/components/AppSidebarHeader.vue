<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType, User } from '@/types';

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItemType[];
        friend?: User | null;
        onlineUserIds?: Set<number>;
    }>(),
    {
        breadcrumbs: () => [],
        friend: null,
        onlineUserIds: () => new Set<number>(),
    },
);
</script>

<template>
    <header
        class="border-sidebar-border/70 flex h-16 shrink-0 items-center justify-between gap-2 border-b px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
    >
        <div class="flex items-center gap-2">
            <SidebarTrigger class="-ml-1" />
            <template v-if="breadcrumbs && breadcrumbs.length > 0">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </template>
        </div>
        <div v-if="friend" class="flex items-center gap-2">
            <span class="h-2 w-2 rounded-full" :class="onlineUserIds.has(friend.id) ? 'bg-green-500' : 'bg-gray-400'" title="Status" />
            <span :class="onlineUserIds.has(friend.id) ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400'">
                {{ onlineUserIds.has(friend.id) ? 'Online' : 'Offline' }}
            </span>
            {{ friend.name }}
        </div>
    </header>
</template>
