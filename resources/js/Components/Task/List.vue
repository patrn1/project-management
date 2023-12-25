<script setup>
import { router } from '@inertiajs/vue3';
import CardGrid from '@/Components/CardGrid.vue';

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

    <div class="p-1 bg-white shadow sm:rounded-lg">
        <v-btn
            variant="tonal"
            @click.stop="router.get(route('projects.create-task', { project: project.id }))"
        >
            Создать задачу
        </v-btn>
    </div>

    <CardGrid
        :itemList="tasks"
        :cardTitleGetter="task => task.name"
        :cardSubtitleGetter="task => `Исполнитель: ${task.assignee_name}`"
        :cardTextGetter="task => task.description"
        :onCardClick="task => router.get(route('tasks.show', { task: task.id }))"
        v-slot="slotProps"
    >
        <v-btn
            @click.stop="router.delete(route('tasks.destroy', { task: slotProps?.item.id }))"
            variant="tonal"
        >Удалить</v-btn>
    </CardGrid>
</template>
