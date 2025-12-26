<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Editar Tarea: {{ task.name }}
      </h2>
    </template>

    <Head :title="`Editar: ${task.name}`" />

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <form @submit.prevent="submitForm">
              <!-- Nombre -->
              <div class="mb-6">
                <label for="name" class="block font-medium text-sm text-gray-700 mb-2">
                  Nombre de la Tarea
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  maxlength="255"
                  class="block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition"
                  :class="form.errors.name ? 'border-red-500' : 'border-gray-300'"
                  required
                />
                <p v-if="form.errors.name" class="text-sm text-red-600 mt-1">
                  {{ form.errors.name }}
                </p>
              </div>

              <!-- Descripción -->
              <div class="mb-6">
                <label for="description" class="block font-medium text-sm text-gray-700 mb-2">
                  Descripción (Opcional)
                </label>
                <textarea
                  id="description"
                  v-model="form.description"
                  maxlength="1000"
                  class="block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition resize-none"
                  :class="form.errors.description ? 'border-red-500' : 'border-gray-300'"
                  rows="4"
                ></textarea>
              </div>

              <!-- Status -->
              <div class="mb-6">
                <label for="status" class="block font-medium text-sm text-gray-700 mb-2">
                  Estado
                </label>
                <select
                  id="status"
                  v-model="form.status"
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition"
                >
                  <option value="pending">Pendiente</option>
                  <option value="in_progress">En progreso</option>
                  <option value="completed">Completada</option>
                </select>
              </div>

              <!-- Priority -->
              <div class="mb-6">
                <label for="priority" class="block font-medium text-sm text-gray-700 mb-2">
                  Prioridad
                </label>
                <select
                  id="priority"
                  v-model="form.priority"
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition"
                >
                  <option value="low">Baja</option>
                  <option value="medium">Media</option>
                  <option value="high">Alta</option>
                </select>
              </div>

              <!-- Due Date -->
              <div class="mb-6">
                <label for="due_date" class="block font-medium text-sm text-gray-700 mb-2">
                  Fecha de Entrega (Opcional)
                </label>
                <input
                  id="due_date"
                  v-model="form.due_date"
                  type="date"
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition"
                />
              </div>

              <!-- Botones -->
              <div class="flex gap-4">
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="form.processing">Guardando...</span>
                  <span v-else>Guardar Cambios</span>
                </button>

                <Link
                  :href="route('tasks.show', task.id)"
                  class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition"
                  :class="{ 'opacity-50 pointer-events-none': form.processing }"
                >
                  Cancelar
                </Link>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Task {
  id: number;
  name: string;
  description: string;
  status: string;
  priority: string;
  due_date: string | null;
}

interface TaskFormData {
  name: string;
  description: string;
  status: string;
  priority: string;
  due_date: string;
}

const props = defineProps<{
  task: Task;
}>();

const form = useForm<TaskFormData>({
  name: props.task.name,
  description: props.task.description,
  status: props.task.status,
  priority: props.task.priority,
  due_date: props.task.due_date || '',
});

const submitForm = (): void => {
  form.put(route('tasks.update', props.task.id), {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<style scoped>
textarea {
  font-family: inherit;
}
</style>
