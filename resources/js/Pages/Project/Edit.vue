<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProjectsForm from '@/Components/Project/Edit.vue';

const props = defineProps({
  readonly: {
    type: Boolean,
  },
  project: {
    type: Object,
  },
});

const projectData = props.project;

let title;

if (props.readonly) {
  title = `Проект: ${projectData.name}`;
} else {
  title = 'Создание проекта';
}

</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ title }}</h2>
        </template>

        <div class="pt-1 pb-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <ProjectsForm :project="project" :readonly="readonly" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
