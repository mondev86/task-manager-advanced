<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Editar Equipo: {{ team.name }}
      </h2>
    </template>

    <Head title="Editar Equipo" />

    <div class="py-12">
      <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
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
                  class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                  placeholder="Ej: Equipo Frontend"
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
                  placeholder="Describe tu equipo..."
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
                  <span v-if="form.processing">Guardando...</span>
                  <span v-else>Guardar Cambios</span>
                </button>

                <button
                  type="button"
                  @click="showDeleteModal = true"
                  class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                  Eliminar Equipo
                </button>

                <Link
                  :href="route('teams.show', team.id)"
                  class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                  Cancelar
                </Link>
              </div>
            </form>
          </div>
        </div>

        <!-- Modal de confirmación para eliminar -->
        <div
          v-if="showDeleteModal"
          class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
          <div class="bg-white rounded-lg p-6 max-w-sm mx-auto shadow-lg">
            <h3 class="text-lg font-bold text-gray-900 mb-4">
              ¿Estás seguro?
            </h3>
            <p class="text-gray-600 mb-6">
              Esta acción eliminará el equipo "{{ team.name }}" y todos sus proyectos y tareas.
              Esta acción no se puede deshacer.
            </p>
            <div class="flex gap-4">
              <button
                @click="confirmDelete"
                :disabled="deleteForm.processing"
                class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <span v-if="deleteForm.processing">Eliminando...</span>
                <span v-else>Sí, Eliminar</span>
              </button>
              <button
                @click="showDeleteModal = false"
                class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150"
              >
                Cancelar
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Team {
  id: number;
  name: string;
  description: string | null;
  created_by: number;
  created_at: string;
  updated_at: string;
}

interface TeamFormData {
  name: string;
  description: string;
}



const props = defineProps<{
  team: Team;
}>();

const form = useForm<TeamFormData>({
  name: props.team.name,
  description: props.team.description || '',
});

const deleteForm = useForm({});

const showDeleteModal = ref<boolean>(false);

const submitForm = (): void => {
  form.put(route('teams.update', props.team.id), {
    onSuccess: () => {
      // El redirect se maneja automáticamente en el controller
    },
  });
};

const confirmDelete = (): void => {
  deleteForm.delete(route('teams.destroy', props.team.id), {
    onSuccess: () => {
      // El redirect se maneja automáticamente en el controller
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
