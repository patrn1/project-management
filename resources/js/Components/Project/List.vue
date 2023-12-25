<style scoped>

</style>
<script setup>
import moment from 'moment';
import { Link, router } from '@inertiajs/vue3';
import CardGrid from '@/Components/CardGrid.vue';

defineProps({
  projects: {
    type: Array,
  },
});

/*
 * Возвращает статус таймера
 *
 * @param milliseconds Number
 * @returns string
 */
const getTimerStatus = (milliseconds) => {
  if (!milliseconds) return null;
  const message = 'Вы проработали на проекте: ';
  const time = moment()
    .startOf('day')
    .add(milliseconds, 'ms');
  const timeString = [
    time.hours() ? time.format('HH часов') : '',
    time.minutes() ? time.format('mm минут') : '',
    time.seconds() ? time.format('ss секунд') : '',
  ]
    .filter((ts) => ts)
    .join(' ');

  return `${message}
${timeString}`;
};

</script>

<template>
    <div class="p-1 bg-white shadow sm:rounded-lg">
        <Link :href="route('projects.create')">
            <v-btn variant="tonal">Создать проект</v-btn>
        </Link>
    </div>

    <CardGrid
        :itemList="projects"
        :cardTitleGetter="project => project.name"
        :cardSubtitleGetter="project => getTimerStatus(project.time_spent)"
        :cardTextGetter="project => project.description"
        :onCardClick="project => router.get(route('projects.tasks', { project: project.id }))"
        v-slot="slotProps"
    >
        <v-btn @click.stop="router.get(route('projects.show', { project: slotProps?.item.id }))" variant="tonal">О проекте</v-btn>
        <v-btn @click.stop="router.delete(route('projects.destroy', { project: slotProps?.item.id }))" variant="tonal">Удалить</v-btn>
    </CardGrid>

</template>
