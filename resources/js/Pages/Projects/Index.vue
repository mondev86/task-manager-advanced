<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Proyectos: {{ team.name }}
        </h2>
        <Link
          v-if="isAdmin"
          :href="route('projects.create', { team: team.id })"
          class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition"
        >
          + Crear Proyecto
        </Link>
      </div>
    </template>

    <Head :title="`Proyectos: ${team.name}`" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Si no hay proyectos -->
        <div v-if="projects.data.length === 0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <p class="text-gray-500 text-center">No hay proyectos en este equipo</p>
        </div>

        <!-- Grid de proyectos -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="project in projects.data"
            :key="project.id"
            class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:shadow-lg transition-shadow"
          >
            <!-- Nombre -->
            <h3 class="text-lg font-bold text-gray-900 mb-2">
              {{ project.name }}
            </h3>

            <!-- Descripción -->
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
              {{ project.description || 'Sin descripción' }}
            </p>

            <!-- Info -->
            <div class="mb-4 text-sm text-gray-500">
              <p>📋 {{ project.tasks_count || 0 }} tareas</p>
            </div>

            <!-- Acciones -->
            <div class="flex gap-2">
              <Link
                :href="route('projects.show', project.id)"
                class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition"
              >
                Ver
              </Link>
              <Link
                v-if="isAdmin"
                :href="route('projects.edit', project.id)"
                class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition"
              >
                Editar
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Project {
  id: number;
  name: string;
  description: string | null;
  tasks_count?: number;
}

interface PaginatedProjects {
  data: Project[];
}

interface Team {
  id: number;
  name: string;
}

const props = defineProps<{
  team: Team;
  projects: PaginatedProjects;
}>();

const page = usePage();

// Acceso a isAdmin desde auth
const isAdmin = computed(() => {
  return page.props.auth?.user?.isAdmin || false;
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
