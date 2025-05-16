<script setup lang="ts">
import AppLayout from "@/layouts/app/AppSidebarLayout.vue";
import type { BreadcrumbItemType, User } from "@/types";

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
  <AppLayout :breadcrumbs="breadcrumbs" :friend="friend" :onlineUserIds="onlineUserIds">
    <slot />
  </AppLayout>
</template>
