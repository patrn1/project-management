<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ProjectsList from '@/Components/Project/List.vue';

defineProps({
  projects: {
    type: Array,
  },
});

</script>

<template>
    <Head title="Проекты" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Проекты</h2>
        </template>

        <div class="pt-1 pb-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <ProjectsList :projects="projects" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
