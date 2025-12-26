<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ team.name }}
        </h2>
        <div class="flex gap-2">
          <Link
            :href="route('teams.edit', team.id)"
            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 transition"
          >
            Editar
          </Link>
          <Link
            :href="route('teams.index')"
            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition"
          >
            Volver
          </Link>
        </div>
      </div>
    </template>

    <Head :title="`Equipo: ${team.name}`" />

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <!-- Información del equipo -->
            <div class="mb-8">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Información del Equipo
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre
                  </label>
                  <p class="text-gray-900">{{ team.name }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Creado
                  </label>
                  <p class="text-gray-900">{{ formatDate(team.created_at) }}</p>
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción
                  </label>
                  <p class="text-gray-900">
                    {{ team.description || 'Sin descripción' }}
                  </p>
                </div>
              </div>
            </div>

            <!-- Miembros del equipo -->
            <div class="border-t pt-8">
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                  Miembros ({{ team.users?.length || 0 }})
                </h3>
              </div>

              <div v-if="team.users && team.users.length > 0" class="space-y-3">
                <div
                  v-for="user in team.users"
                  :key="user.id"
                  class="flex items-center justify-between p-3 bg-gray-50 rounded-md"
                >
                  <div>
                    <p class="font-medium text-gray-900">{{ user.name }}</p>
                    <p class="text-sm text-gray-600">{{ user.email }}</p>
                  </div>
                </div>
              </div>
              <div v-else class="text-center py-6 text-gray-500">
                <p>No hay miembros en este equipo</p>
              </div>
            </div>

            <!-- Proyectos del equipo -->
            <div class="border-t pt-8">
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                  Proyectos ({{ team.projects?.length || 0 }})
                </h3>
                <div class="flex gap-2">
                  <Link
                    :href="`/teams/${team.id}/projects/create`"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm font-medium transition"
                  >
                    + Crear Proyecto
                  </Link>
                  <Link
                    :href="`/teams/${team.id}/projects`"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium transition"
                  >
                    Ver todos →
                  </Link>
                </div>
              </div>

              <div v-if="team.projects && team.projects.length > 0" class="space-y-3">
                <Link
                  v-for="project in team.projects"
                  :key="project.id"
                  :href="route('projects.show', project.id)"
                  class="block p-3 bg-gray-50 rounded-md hover:bg-gray-100 transition"
                >
                  <p class="font-medium text-gray-900">{{ project.name }}</p>
                  <p class="text-sm text-gray-600">{{ project.description }}</p>
                </Link>
              </div>
              <div v-else class="text-center py-6 text-gray-500">
                <p>No hay proyectos en este equipo</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

interface User {
  id: number;
  name: string;
  email: string;
}

interface Project {
  id: number;
  name: string;
  description: string;
}

interface Team {
  id: number;
  name: string;
  description: string;
  created_at: string;
  users?: User[];
  projects?: Project[];
}

defineProps<{
  team: Team;
}>();

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};
</script>
