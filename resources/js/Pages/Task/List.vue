<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TasksList from '@/Components/Task/List.vue';

defineProps({
  tasks: {
    type: Array,
  },
  project: {
    type: Object,
  },
});

</script>

<template>
    <Head title="Задачи" />

    <AuthenticatedLayout>
        <template #header>
            <div class="mb-2">
                Проект: {{ project.name }}
            </div>

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Задачи</h2>
        </template>

        <div class="pt-1 pb-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <TasksList
                    :tasks="tasks"
                    :project="project"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
