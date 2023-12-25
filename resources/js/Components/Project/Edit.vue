<style scoped>
label {
  font-weight: bold;
}
</style>
<script setup>

import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
  project: {
    type: Object,
  },
  readonly: {
    type: Boolean,
  },
});

const { project } = props;
const readonly = ref(props.readonly);

const form = useForm({
  name: project?.name,
  description: project?.description,
  valid: true,
});

/*
 * Сохраняет форму
 *
 * @param _form Object
 */
function saveForm(_form) {
  const config = { preserveScroll: true };

  if (project.id) {
    _form.put(route('projects.update', { project: project.id }), config);
  } else {
    _form.post(route('projects.store'), config);
  }
}
</script>

<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
      <v-form :readonly="readonly" v-model="form.valid">
        <v-container>
          <v-row>
            <v-col
              cols="12"
            >
              <div class="pb-2">
                <label>Название</label>
              </div>
              <p v-if="readonly">{{ form.name }}</p>
              <v-text-field
                v-else
                v-model="form.name"
                required
              ></v-text-field>
              <InputError class="mt-2" :message="form.errors.name" />
            </v-col>
          </v-row>
          <v-row>
            <v-col
              cols="12"
            >
              <div class="pb-2">
                <label>Описание</label>
              </div>
              <pre v-if="readonly">{{ form.description }}</pre>
              <v-textarea
                v-else
                v-model="form.description"
              ></v-textarea>
              <InputError class="mt-2" :message="form.errors.description" />
            </v-col>
          </v-row>
          <v-row>
            <v-col
              cols="12"
            >
              <template v-if="readonly">
                <v-btn variant="tonal" class="mr-1" v-if="project?.id" @click="readonly = !readonly">Редактировать</v-btn>
              </template>
              <template v-else>
                <v-btn variant="tonal" class="mr-1" @click="saveForm(form)">Сохранить</v-btn>
                <v-btn variant="tonal" class="mr-1" v-if="project?.id" @click="readonly = true">Отмена</v-btn>
              </template>
            </v-col>
          </v-row>
        </v-container>
      </v-form>
    </div>
</template>
