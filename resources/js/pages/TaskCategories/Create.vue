<script setup lang="ts">

import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import AppLayout from '@/layouts/AppLayout.vue';

import { Head, useForm } from '@inertiajs/vue3';
import { BreadcrumbItem } from '@/types';


const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Tasks', href: '/tasks' },
    { title: 'Task Categories', href: '/task-categories' },
    { title: 'Create', href: '/task-categories/create' },
];

const form = useForm({
    name: '',
});


const submitForm = () => {
    form.post(route('task-categories.store'), {
        preserveScroll: true,
    });
};

</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Create Task" />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <form class="space-y-6" @submit.prevent="submitForm">
                <div class="grid gap-2">
                    <Label htmlFor="name">Name *</Label>

                    <Input id="name" v-model="form.name" class="mt-1 block w-full" />

                    <InputError :message="form.errors.name" />
                </div>
                <div class="flex items-center gap-4">
                    <Button :disabled="form.processing" variant="default">
                        Create Task Category
                    </Button>
                </div>
            </form>
        </div>
    </AppLayout>


</template>