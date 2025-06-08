<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

import BarChart from '@/components/BarChart.vue'
import DonutChart from '@/components/DonutChart.vue'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface Props {
    completedVsPendingTaskChart: { name: string; total: number }[];
    pendingTasksToday: number;
    tasksCreatedByDay: { name: string; TotalTasks: number }[]; 
}

defineProps<Props>();

</script>

<template>
    <Head title="Dashboard" />
    
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
                    <h2 class="pb-4 text-center text-3xl font-bold">Progress Overview</h2>
                    <DonutChart
                        class="h-full"
                        :data="completedVsPendingTaskChart"
                        :colors="['#00a64b', '#e3544f']"
                        index="name"      category="total"  />
                </div>

                <div
                    class="relative flex aspect-video flex-col items-center justify-center overflow-hidden rounded-xl border border-sidebar-border/70 py-4 dark:border-sidebar-border"
                >
                    <h2 class="text-center text-3xl font-bold">Tasks Due Today</h2>
                    <p class="text-xl">{{ pendingTasksToday }} task(-s) due today.</p>
                </div>

            </div>

            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <h2 class="pb-4 text-center text-3xl font-bold pt-4">Tasks by Day</h2>
                    <BarChart
                        class="h-full p-4"
                        :data="tasksCreatedByDay"
                        index="name"       :categories="['TotalTasks']" label="Tasks Created" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>