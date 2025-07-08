<script setup lang="ts">
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { type Task } from '@/types';
import { Head, router, Link } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import {Button, buttonVariants} from "@/components/ui/button";

interface Props {
    tasks: Task[];
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
</script>

<template>
    <AppLayout>
        <Head title="Index" />
        <div class="mt-4">
            <Link :class="buttonVariants({ variant: 'outline' })" href="route('tasks.create')">
               Add Task
            </Link>
        </div>
        <Table class="mt-4">
            <TableHeader>
                <TableRow>
                    <TableHead>Task</TableHead>
                    <TableHead class="w-[100px]">Status</TableHead>
                    <TableHead class="w-[100px] text-right">Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="task in tasks" :key="task.id">
                    <TableCell>{{ task.name }}</TableCell>
                    <TableCell :class="task.is_completed ? 'text-green-500' : 'text-red-500'">{{
                        task.is_completed ? 'Completed' : 'In Progress'
                    }}</TableCell>
                    <TableCell class="text-right">
                        <Button class="mr-2" @click="deleteTask(task.id)" variant="destructive">Delete</Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </AppLayout>
</template>
