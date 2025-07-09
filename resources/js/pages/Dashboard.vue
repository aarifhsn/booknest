<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

import { ArcElement, BarElement, CategoryScale, Chart, Legend, LinearScale, Title, Tooltip } from 'chart.js';
import { Bar, Doughnut } from 'vue-chartjs';

Chart.register(ArcElement, Tooltip, Legend, CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface Props {
    completedVsPendingTaskChart: [];
    pendingTasksToday: number;
    tasksCreatedByDay: object;
}

defineProps<Props>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <Doughnut :data="completedVsPendingTaskChart" class="mx-auto" />
                </div>
                <div
                    class="relative flex aspect-video flex-col items-center justify-start overflow-hidden rounded-xl border border-sidebar-border/70 py-4 dark:border-sidebar-border"
                >
                    <h2 class="text-center text-3xl font-bold">Tasks Due Today</h2>
                    <p class="mt-auto mb-auto text-xl">{{ pendingTasksToday }} task(-s) due today.</p>
                </div>
                <div
                    class="relative flex aspect-video flex-col items-center justify-start overflow-hidden rounded-xl border border-sidebar-border/70 py-4 dark:border-sidebar-border"
                >
                    <h2 class="text-center text-3xl font-bold">Tasks This Week</h2>
                    <Bar :data="tasksCreatedByDay" class="mx-auto" />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
