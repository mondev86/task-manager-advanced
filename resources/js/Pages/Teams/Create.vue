<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Crear Nuevo Equipo
      </h2>
    </template>

    <Head title="Crear Equipo" />

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <!-- General error alert -->
            <div v-if="form.hasErrors && !hasFieldErrors" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-md">
              <p class="text-sm text-red-700">
                Ocurrió un error al crear el equipo. Por favor, intenta de nuevo.
              </p>
            </div>

            <form @submit.prevent="submitForm">
              <!-- Campo: Nombre -->
              <div class="mb-6">
                <label for="name" class="block font-medium text-sm text-gray-700 mb-2">
                  Nombre del Equipo
                </label>
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  maxlength="100"
                  class="block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition"
                  :class="form.errors.name ? 'border-red-500' : 'border-gray-300'"
                  placeholder="Ej: Equipo Frontend"
                  aria-invalid="false"
                  :aria-describedby="form.errors.name ? 'name-error' : undefined"
                  required
                />
                <div class="flex justify-between items-start mt-1">
                  <p v-if="form.errors.name" id="name-error" class="text-sm text-red-600">
                    {{ form.errors.name }}
                  </p>
                  <span class="text-xs text-gray-500 ml-auto">
                    {{ form.name.length }}/100
                  </span>
                </div>
              </div>

              <!-- Campo: Descripción -->
              <div class="mb-6">
                <label for="description" class="block font-medium text-sm text-gray-700 mb-2">
                  Descripción (Opcional)
                </label>
                <textarea
                  id="description"
                  v-model="form.description"
                  maxlength="500"
                  class="block w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition resize-none"
                  :class="form.errors.description ? 'border-red-500' : 'border-gray-300'"
                  placeholder="Describe tu equipo..."
                  rows="4"
                  :aria-describedby="form.errors.description ? 'description-error' : undefined"
                ></textarea>
                <div class="flex justify-between items-start mt-1">
                  <p v-if="form.errors.description" id="description-error" class="text-sm text-red-600">
                    {{ form.errors.description }}
                  </p>
                  <span class="text-xs text-gray-500 ml-auto">
                    {{ form.description.length }}/500
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
                  <span v-if="form.processing">Creando...</span>
                  <span v-else>Crear Equipo</span>
                </button>

                <Link
                  :href="route('teams.index')"
                  class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
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

interface TeamFormData {
  name: string;
  description: string;
}

const form = useForm<TeamFormData>({
  name: '',
  description: '',
});

const hasFieldErrors = computed(() => {
  return Object.keys(form.errors).length > 0;
});

const submitForm = (): void => {
  form.post(route('teams.store'), {
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

