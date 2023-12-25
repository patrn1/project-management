<style scoped>
label {
  font-weight: bold;
}
</style>
<script setup>
import moment from 'moment';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import axios from 'axios';
import InputError from '@/Components/InputError.vue';

/*
 * Возвращает Moment в UTC режиме.
 *
 * @param {...*} params
 * @returns Object
 */
const momentUtc = (...params) => moment.utc(...params);

const page = usePage();

const currentUser = computed(() => page.props.auth.user);

const props = defineProps({
  task: {
    type: Object,
  },
  project: {
    type: Object,
  },
  users: {
    type: Array,
  },
  readonly: {
    type: Boolean,
  },
});

const users = ref(props.users || []);

const { task } = props;
const { project } = props;
const readonly = ref(props.readonly);
const { assignee_name } = task;

const form = useForm({
  name: task.name,
  description: task.description,
  assignee_id: task.assignee_id,
  project_id: project.id,
});

const timerForm = useForm({
  timer_started_at: task.timer_started_at,
  timer_stopped_at: task.timer_stopped_at,
  redirect: false,
});

const timer = ref(getTimerVlue());

/*
 * Возвращает значение таймера
 *
 * @returns string
 */
function getTimerVlue() {
  if (!timerForm.timer_started_at) return null;
  const diff = momentUtc().valueOf() - momentUtc(timerForm.timer_started_at).valueOf();
  return momentUtc(diff).format('HH:mm:ss');
}

watch(timer, async () => {
  if (timerForm.timer_started_at && !timerForm.timer_stopped_at) {
    setTimeout(() => {
      timer.value = getTimerVlue();
    }, 1000);
  }
}, { immediate: true });

/*
 * Ищет пользователей по запросу и обновляет список пользователей.
 *
 * @param string query
 */
function searchUsers(query) {
  axios({
    method: 'get',
    url: route('users.search'),
    params: {
      query,
    },
  }).then((res) => users.value = res.data);
}

/*
 * Сохраняет форму
 *
 * @param Object _form
 * @param string routeName
 * @param boolean preserveState
 */
function saveForm(_form, routeName, preserveState) {
  preserveState = preserveState !== false;

  const config = { preserveScroll: true, preserveState };

  if (task.id) {
    _form.put(route(routeName || 'tasks.update', { task: task.id }), config);
  } else {
    _form.post(route(routeName || 'tasks.store'), config);
  }
}

/*
 * Сохраняет форму таймера
 */
function saveTimerForm() {
  return saveForm(timerForm, 'tasks.update-timer', false);
}

/*
 * Переключает таймер
 */
function toggleTimer() {
  const now = momentUtc().format('YYYY-MM-DD HH:mm:ss');

  if (timerForm.timer_started_at) {
    if (timerForm.timer_stopped_at) {
      timerForm.timer_stopped_at = null;
    } else {
      timerForm.timer_stopped_at = now;
    }
  } else {
    timerForm.timer_started_at = now;
  }

  saveTimerForm();
}

/*
 * Сбрасывает таймер
 */
function resetTimer() {
  timerForm.timer_started_at = null;
  timerForm.timer_stopped_at = null;
  saveTimerForm();
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
                <label>Исполнитель</label>
              </div>
              <p v-if="readonly">{{ assignee_name }}</p>
              <v-combobox
                v-else
                item-title="name"
                item-value="id"
                v-model="assignee_name"
                :items="users"
                @update:search="searchUsers"
                @update:modelValue="assignee => form.assignee_id = assignee?.id"
              ></v-combobox>
              <InputError class="mt-2" :message="form.errors.assignee_id" />
            </v-col>
          </v-row>
          <v-row v-if="readonly">
            <v-col
              cols="12"
            >
              <div class="pb-2">
                <label>Таймер</label>
              </div>
              <div v-if="timer">Времени затрачено: {{ timer }}</div>
              <div v-if="currentUser?.id === form.assignee_id" class="mt-1">
                <v-btn
                  variant="outlined"
                  class="mr-1"
                  @click="toggleTimer()"
                >
                  <svg v-if="timerForm.timer_started_at && !timerForm.timer_stopped_at" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#000" d="M8 5a2 2 0 0 0-2 2v10a2 2 0 1 0 4 0V7a2 2 0 0 0-2-2zm8 0a2 2 0 0 0-2 2v10a2 2 0 1 0 4 0V7a2 2 0 0 0-2-2z"/></svg>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"><path fill="#000" d="M7 17.259V6.741a1 1 0 0 1 1.504-.864l9.015 5.26a1 1 0 0 1 0 1.727l-9.015 5.259A1 1 0 0 1 7 17.259Z"/></svg>
                </v-btn>
                <v-btn variant="outlined" class="mr-1" @click="resetTimer()">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M8 6h8c1.1 0 2 .9 2 2v8c0 1.1-.9 2-2 2H8c-1.1 0-2-.9-2-2V8c0-1.1.9-2 2-2z"/></svg>
                </v-btn>
              </div>
              <InputError class="mt-2" :message="timerForm.errors.timer_started_at" />
              <InputError class="mt-2" :message="timerForm.errors.timer_stopped_at" />
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
          <v-row class="mt-2">
            <v-col
              cols="12"
            >
              <template v-if="readonly">
                <v-btn variant="tonal" class="mr-1" v-if="task?.id" @click="readonly = !readonly">Редактировать</v-btn>
              </template>
              <template v-else>
                <v-btn variant="tonal" class="mr-1" @click="saveForm(form)">Сохранить</v-btn>
                <v-btn variant="tonal" class="mr-1" v-if="task?.id" @click="readonly = true">Отмена</v-btn>
              </template>
            </v-col>
          </v-row>
        </v-container>
      </v-form>
    </div>
</template>
