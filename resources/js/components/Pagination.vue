<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

interface PaginationLink {
  url: string | null;
  label: string;
  active?: boolean;
}

defineProps<{ links: PaginationLink[] }>();
</script>

<template>
  <div
    class="flex flex-wrap justify-center items-center gap-2 py-4 text-xs sm:text-sm md:text-base"
  >
    <template v-for="(link, index) in links" :key="index">
      <span
        v-if="link.url === null"
        v-html="link.label"
        class="text-gray-500 px-2"
      ></span>
      <Link
        v-else
        preserve-scroll
        :href="link.url"
        class="px-3 py-1 border rounded text-center transition duration-150 ease-in-out"
        :class="{
          'text-gray-700 hover:bg-gray-200': !link.active,
          'font-bold bg-gray-800 text-white': link.active,
        }"
      >
        <span v-html="link.label"></span>
      </Link>
    </template>
  </div>
</template>
