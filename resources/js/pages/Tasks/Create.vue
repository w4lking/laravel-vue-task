<script setup lang="ts">

// html
import InputError from '@/components/InputError.vue';

import { Card, CardContent, CardFooter, CardTitle, CardDescription } from '@/components/ui/card';    

import { Button } from '@/components/ui/button';
import { Switch } from '@/components/ui/switch';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, TaskCategory } from '@/types';

import { ToggleGroup, ToggleGroupItem } from '@/components/ui/toggle-group';

import { Calendar } from '@/components/ui/calendar';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { cn } from '@/lib/utils';
import { DateFormatter, getLocalTimeZone } from '@internationalized/date';

import { CalendarIcon, Car } from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3';
import CardHeader from '@/components/ui/card/CardHeader.vue';


interface Props{
    categories: TaskCategory[];
}

const props = defineProps<Props>();

const categories = props.categories;

const df = new DateFormatter('en-US', {
    dateStyle: 'short',
});


const form = useForm({
    name: '',
    due_date: undefined,
    media: undefined as string | File | undefined,
    categories: [],
});

const fileSelected = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];

    if (!file) {
        return;
    }

    form.media = file;
};

const submitForm = () => {
    form.transform((data) => ({
        ...data,
        due_date: data.due_date ? data.due_date.toDate(getLocalTimeZone()) : null,
    })).post(route('tasks.store'), {
        preserveScroll: true,
    });
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Tasks', href: '/tasks' },
    { title: 'Create Task', href: '' },
];

</script>


<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Create Task" />

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <form class="space-y-6" @submit.prevent="submitForm">
                <Card class="py-6">
                    <CardHeader>
                        <CardTitle>Details of Task</CardTitle>
                        <CardDescription>Fill in the details of the task you want to create.</CardDescription>
                    </CardHeader>

                    <CardContent class="grid gap-6 p-6">

                        <div class="grid gap-2 md:grid-cols-2 lg:grid-cols-3">
                            <div class="md:col-span-2 lg:col-span-2 grid gap-2">
                                <Label htmlFor="name">Task Name * <InputError :message="form.errors.name" /></Label> 

                                <Input id="name" v-model="form.name" class="mt-1 block w-full" />
                                
                            </div>
                        

                            <div class="grid gap-2">
                                <Label htmlFor="name">Due Date</Label>

                                <Popover>
                                    <PopoverTrigger as-child>
                                        <Button variant="outline" :class="cn('w-full justify-start text-left font-normal', !form.due_date && 'text-muted-foreground')">
                                            <CalendarIcon class="mr-2 h-4 w-4" />
                                            {{ form.due_date ? df.format(form.due_date.toDate(getLocalTimeZone())) : 'Select a date' }}
                                        </Button>
                                    </PopoverTrigger>
                                    <PopoverContent class="w-auto p-0">
                                        <Calendar v-model="form.due_date" initial-focus />
                                    </PopoverContent>

                                    <InputError :message="form.errors.due_date" />
                                </Popover>
                            </div>
                        </div>

                        <div class="grid gap-2">
                            <Label htmlFor="is_completed">Completed</Label>

                            <Switch id="is_completed" v-model:checked="form.is_completed" class="mt-1" />

                            <InputError :message="form.errors.is_completed" />
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="grid gap-2">

                                <Label htmlFor="name">Media</Label>

                                <Input type="file" id="name" v-on:change="fileSelected($event)" class="w-full" />

                                <progress v-if="form.progress" :value="form.progress.percentage" max="100" class="w-full mt-2">{form.progress.percentage}%</progress>

                                <InputError :message="form.errors.media" />
                                
                            </div>
                        

                            <div class="grid gap-2">
                                <Label htmlFor="categories">Categories</Label>
            
                                <ToggleGroup type="multiple" variant="outline" size="lg" v-model="form.categories" class="flex flex-wrap gap-2 justify-start w-full">
                                    <ToggleGroupItem v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </ToggleGroupItem>
                                </ToggleGroup>
            
                                <InputError :message="form.errors.categories" />
                            </div>
                        </div>
                    </CardContent>
                
                    <CardFooter>
                        <div class="flex items-center gap-4">
                            <Button :disabled="form.processing" variant="default">Create Task</Button>
                        </div>
                    </CardFooter>
                </Card>
            </form>
        </div>
    </AppLayout>
</template>