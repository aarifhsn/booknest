<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import { Button, buttonVariants } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type PaginatedResponse, type Task } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { DateFormatter } from '@internationalized/date';
import { toast } from 'vue-sonner';

interface Props {
    tasks: PaginatedResponse<Task>;
}

defineProps<Props>();

const deleteTask = (id: number) => {
    if (confirm('Are you sure you want to delete this task?')) {
        router.delete(route('tasks.destroy', { id }), {
            onSuccess: () => toast.success('Task deleted successfully'),
            onError: () => toast.error('Failed to delete task'),
        });
    }
};

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Tasks', href: '/tasks' },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Index" />
        <div class="mt-4">
            <Link :class="buttonVariants({ variant: 'outline' })" :href="route('tasks.create')"> Add Task </Link>
        </div>
        <Table class="mt-4">
            <TableHeader>
                <TableRow>
                    <TableHead>Task</TableHead>
                    <TableHead>File</TableHead>
                    <TableHead class="w-[100px]">Status</TableHead>
                    <TableHead class="w-[100px]">Due Date</TableHead>
                    <TableHead class="w-[100px] text-right">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="task in tasks.data" :key="task.id">
                    <TableCell>{{ task.name }}</TableCell>
                    <TableCell>
                        <a v-if="task.mediaFile" :href="task.mediaFile.original_url" target="_blank">
                            <img :src="task.mediaFile.original_url" class="h-8 w-8" />
                        </a>
                    </TableCell>
                    <TableCell :class="task.is_completed ? 'text-green-500' : 'text-red-500'">{{
                        task.is_completed ? 'Completed' : 'In Progress'
                    }}</TableCell>
                    <TableCell>{{ task.due_date ? df.format(new Date(task.due_date)) : '-' }}</TableCell>
                    <TableCell class="flex gap-x-2 text-right">
                        <Link :class="buttonVariants({ variant: 'default' })" :href="route('tasks.edit', { id: task.id })">Edit</Link>
                        <Button class="mr-2" @click="deleteTask(task.id)" variant="destructive">Delete</Button>
                    </TableCell>

                    <TableCell>
                        <div class="text-xs text-red-500">
                            {{ task.mediaFile?.original_url }}
                        </div>
                        <a v-if="task.mediaFile" :href="task.mediaFile.original_url" target="_blank">
                            <img :src="task.mediaFile.original_url" class="h-8 w-8" />
                        </a>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>

        <Pagination :resource="tasks" />
    </AppLayout>
</template>
