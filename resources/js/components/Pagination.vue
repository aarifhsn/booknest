<script setup lang="ts">
import type { PaginatedResponse } from '@/types';
import { router } from '@inertiajs/vue3';

const props = defineProps<{
    resource: PaginatedResponse;
}>();
</script>

<template>
    <div class="mt-4 flex justify-center space-x-2">
        <button
            :disabled="!props.resource.prev_page_url"
            @click="router.visit(props.resource.prev_page_url!)"
            class="rounded bg-gray-200 px-4 py-2 text-sm text-gray-800 hover:bg-gray-300 disabled:cursor-not-allowed disabled:opacity-50"
        >
            Previous
        </button>

        <button
            :disabled="!props.resource.next_page_url"
            @click="router.visit(props.resource.next_page_url!)"
            class="rounded bg-gray-200 px-4 py-2 text-sm text-gray-800 hover:bg-gray-300 disabled:cursor-not-allowed disabled:opacity-50"
        >
            Next
        </button>
    </div>
</template>
