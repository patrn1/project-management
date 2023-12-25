<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TaskForm from '@/Components/Task/Edit.vue';

const props = defineProps({
  project: {
    type: Number,
  },
  task: {
    type: Object,
  },
  users: {
    type: Array,
  },
  readonly: {
    type: Boolean,
  },
});

const taskData = props.task;
const projectData = props.project;

let title;
const taskName = `# ${taskData.id}: ${taskData.name}`;

if (props.readonly) {
  title = `Задача ${taskName}`;
} else {
  title = 'Создание задачи';
}

</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <div class="mb-2">
                Проект: <Link class="font-medium text-blue-600 dark:text-blue-500 hover:underline" :href="route('projects.tasks', { project: projectData.id })">{{ projectData.name }}</Link>
            </div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ title }}
            </h2>
        </template>
        <div class="pt-1 pb-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <TaskForm
                    :readonly="readonly"
                    :task="task"
                    :project="project"
                    :users="users"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
