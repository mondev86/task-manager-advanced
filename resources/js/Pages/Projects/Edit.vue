<template>
  <AuthenticatedLayout>
    <template #header>
     <h2 class="font-semibold text-xl text-gray-800 leading-tight">
  Editar Proyecto: {{ props.project.name }}
</h2>
    </template>

    <Head :title="`Editar: ${project.name}`" />

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <div v-if="form.hasErrors && !hasFieldErrors" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-md">
              <p class="text-sm text-red-700">
                Ocurrió un error. Por favor, intenta de nuevo.
              </p>
            </div>

            <form @submit.prevent="submitForm">
              <!-- Nombre -->
              <div class="mb-6">
                <label for="name" class="block font-medium text-sm text-gray-700 mb-2">
                  Nombre del Proyecto
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  maxlength="255"
                  class="block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition"
                  :class="form.errors.name ? 'border-red-500' : 'border-gray-300'"
                  placeholder="Ej: API REST"
                  required
                />
                <div class="flex justify-between items-start mt-1">
                  <p v-if="form.errors.name" class="text-sm text-red-600">
                    {{ form.errors.name }}
                  </p>
                  <span class="text-xs text-gray-500 ml-auto">
                    {{ form.name.length }}/255
                  </span>
                </div>
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
                  placeholder="Describe el proyecto..."
                  rows="4"
                ></textarea>
                <div class="flex justify-between items-start mt-1">
                  <p v-if="form.errors.description" class="text-sm text-red-600">
                    {{ form.errors.description }}
                  </p>
                  <span class="text-xs text-gray-500 ml-auto">
                    {{ form.description.length }}/1000
                  </span>
                </div>
              </div>

              <!-- Botones -->
              <div class="flex gap-4">
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="form.processing">Guardando...</span>
                  <span v-else>Guardar Cambios</span>
                </button>

                <Link
                  :href="route('projects.show', project.id)"
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
import { computed } from 'vue';

interface Project {
  id: number;
  name: string;
  description: string;
}

interface ProjectFormData {
  name: string;
  description: string;
}

const props = defineProps<{
  project: Project;
}>();

const form = useForm<ProjectFormData>({
  name: props.project.name,
  description: props.project.description,
});

const hasFieldErrors = computed(() => {
  return Object.keys(form.errors).length > 0;
});

const submitForm = (): void => {
  form.put(route('projects.update', props.project.id), {
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
