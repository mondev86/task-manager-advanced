<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Mis Equipos
        </h2>
        <Link
          :href="route('teams.create')"
          class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
        >
          + Crear Equipo
        </Link>
      </div>
    </template>

    <Head title="Mis Equipos" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Si no hay equipos -->
        <div v-if="teams.data.length === 0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <p class="text-gray-500 text-center">No tienes equipos aún. ¡Crea uno!</p>
        </div>

        <!-- Grid de equipos -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="team in teams.data"
            :key="team.id"
            class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-lg transition-shadow"
          >
            <!-- Nombre del equipo -->
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              {{ team.name }}
            </h3>

            <!-- Descripción -->
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
              {{ team.description || 'Sin descripción' }}
            </p>

            <!-- Información -->
            <div class="mb-4 text-sm text-gray-500">
              <p>👥 {{ team.users_count || 0 }} miembros</p>
              <p>📁 {{ team.projects_count || 0 }} proyectos</p>
            </div>

            <!-- Acciones -->
            <div class="flex gap-2">
              <Link
                :href="route('teams.show', team.id)"
                class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150"
              >
                Ver
              </Link>
              <Link
                :href="route('teams.edit', team.id)"
                class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150"
              >
                Editar
              </Link>
            </div>
          </div>
        </div>

        <!-- Paginación -->
        <div v-if="teams.links" class="mt-6">
          <div class="flex justify-between items-center">
            <Link
              v-if="teams.links.prev"
              :href="teams.links.prev"
              class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700"
            >
              ← Anterior
            </Link>
            <span v-else class="px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
              ← Anterior
            </span>

            <Link
              v-if="teams.links.next"
              :href="teams.links.next"
              class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
            >
              Siguiente →
            </Link>
            <span v-else class="px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
              Siguiente →
            </span>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

interface Team {
  id: number;
  name: string;
  description: string | null;
  created_by: number;
  users_count?: number;
  projects_count?: number;
  created_at: string;
  updated_at: string;
}

interface PaginationLinks {
  first: string;
  last: string;
  prev: string | null;
  next: string | null;
}

interface PaginatedTeams {
  data: Team[];
  links: PaginationLinks;
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
}

defineProps<{
  teams: PaginatedTeams;
}>();
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
