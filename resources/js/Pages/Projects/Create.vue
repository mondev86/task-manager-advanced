<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Crear Nuevo Proyecto en {{ team.name }}
      </h2>
    </template>

    <Head title="Crear Proyecto" />

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <form @submit.prevent="submitForm">
              <!-- Campo: Nombre -->
              <div class="mb-6">
                <label for="name" class="block font-medium text-sm text-gray-700 mb-2">
                  Nombre del Proyecto
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                  placeholder="Ej: Sistema de Facturación"
                  required
                />
                <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">
                  {{ form.errors.name }}
                </p>
              </div>

              <!-- Campo: Descripción -->
              <div class="mb-6">
                <label for="description" class="block font-medium text-sm text-gray-700 mb-2">
                  Descripción (Opcional)
                </label>
                <textarea
                  id="description"
                  v-model="form.description"
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                  placeholder="Describe los objetivos del proyecto..."
                  rows="4"
                ></textarea>
                <p v-if="form.errors.description" class="mt-1 text-sm text-red-600">
                  {{ form.errors.description }}
                </p>
              </div>

              <!-- Botones -->
              <div class="flex gap-4">
                <button
                  type="submit"
                  :disabled="form.processing"
                  class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  <span v-if="form.processing">Creando...</span>
                  <span v-else>Crear Proyecto</span>
                </button>

<Link
          :href="`/teams/${team.id}/projects`"
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

interface Team {
  id: number;
  name: string;
  description: string | null;
  created_at: string;
  updated_at: string;
}

interface ProjectFormData {
  name: string;
  description: string;
}

const props = defineProps<{
  team: Team;
}>();

const form = useForm<ProjectFormData>({
  name: '',
  description: '',
});

const submitForm = (): void => {
  form.post(route('projects.store', props.team.id), {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<style scoped>
input:focus,
textarea:focus {
  outline: none;
}
</style>
