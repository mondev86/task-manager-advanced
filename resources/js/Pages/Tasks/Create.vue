<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Crear Nueva Tarea
      </h2>
    </template>

    <Head title="Crear Tarea" />

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
                  placeholder="Ej: Implementar login"
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
                  placeholder="Describe la tarea..."
                  rows="4"
                ></textarea>
                <p v-if="form.errors.description" class="text-sm text-red-600 mt-1">
                  {{ form.errors.description }}
                </p>
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
                  :class="form.errors.status ? 'border-red-500' : 'border-gray-300'"
                >
                  <option value="pending">Pendiente</option>
                  <option value="in_progress">En progreso</option>
                  <option value="completed">Completada</option>
                </select>
                <p v-if="form.errors.status" class="text-sm text-red-600 mt-1">
                  {{ form.errors.status }}
                </p>
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
                  :class="form.errors.priority ? 'border-red-500' : 'border-gray-300'"
                >
                  <option value="low">Baja</option>
                  <option value="medium">Media</option>
                  <option value="high">Alta</option>
                </select>
                <p v-if="form.errors.priority" class="text-sm text-red-600 mt-1">
                  {{ form.errors.priority }}
                </p>
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
                  :class="form.errors.due_date ? 'border-red-500' : 'border-gray-300'"
                />
                <p v-if="form.errors.due_date" class="text-sm text-red-600 mt-1">
                  {{ form.errors.due_date }}
                </p>
              </div>

              <!-- Botones -->
              <div class="flex gap-4">
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="form.processing">Creando...</span>
                  <span v-else>Crear Tarea</span>
                </button>

                <Link
                  :href="`/projects/${project.id}`"
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

interface Project {
  id: number;
  name: string;
}

interface TaskFormData {
  name: string;
  description: string;
  status: string;
  priority: string;
  due_date: string;
}

const props = defineProps<{
  project: Project;
}>();

const form = useForm<TaskFormData>({
  name: '',
  description: '',
  status: 'pending',
  priority: 'medium',
  due_date: '',
});

const submitForm = (): void => {
  form.post(`/projects/${props.project.id}/tasks`, {
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
