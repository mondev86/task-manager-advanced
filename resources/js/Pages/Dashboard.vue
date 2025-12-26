<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <Head title="Dashboard" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Tarjetas de Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
          <!-- Total de Equipos -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <div class="flex items-center">
                <div class="flex-1">
                  <p class="text-gray-500 text-sm font-medium">Total de Equipos</p>
                  <p class="text-3xl font-bold text-gray-900 mt-2">
                    {{ teamsCount }}
                  </p>
                </div>
                <div class="text-4xl text-indigo-600 opacity-20">👥</div>
              </div>
              <Link
                href="/teams"
                class="mt-4 inline-block text-indigo-600 hover:text-indigo-700 text-sm font-medium"
              >
                Ver equipos →
              </Link>
            </div>
          </div>

          <!-- Total de Proyectos -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <div class="flex items-center">
                <div class="flex-1">
                  <p class="text-gray-500 text-sm font-medium">Total de Proyectos</p>
                  <p class="text-3xl font-bold text-gray-900 mt-2">
                    {{ projectsCount }}
                  </p>
                </div>
                <div class="text-4xl text-blue-600 opacity-20">📁</div>
              </div>
            </div>
          </div>

          <!-- Total de Tareas -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <div class="flex items-center">
                <div class="flex-1">
                  <p class="text-gray-500 text-sm font-medium">Total de Tareas</p>
                  <p class="text-3xl font-bold text-gray-900 mt-2">
                    {{ tasksCount }}
                  </p>
                </div>
                <div class="text-4xl text-green-600 opacity-20">✓</div>
              </div>
            </div>
          </div>

          <!-- Tareas Completadas -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <div class="flex items-center">
                <div class="flex-1">
                  <p class="text-gray-500 text-sm font-medium">Completadas</p>
                  <p class="text-3xl font-bold text-green-600 mt-2">
                    {{ tasksByStatus.completed }}
                  </p>
                </div>
                <div class="text-4xl opacity-20">🎉</div>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
          <!-- Estado de Tareas -->
          <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-6">
                Estado de Tareas
              </h3>

              <div class="space-y-4">
                <!-- Pendientes -->
                <div>
                  <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Pendientes</span>
                    <span class="text-sm font-bold text-gray-900">
                      {{ tasksByStatus.pending }}
                    </span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-2">
                    <div
                      class="bg-yellow-500 h-2 rounded-full transition-all"
                      :style="{
                        width: tasksCount > 0
                          ? (tasksByStatus.pending / tasksCount * 100) + '%'
                          : '0%'
                      }"
                    ></div>
                  </div>
                </div>

                <!-- En Progreso -->
                <div>
                  <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">En Progreso</span>
                    <span class="text-sm font-bold text-gray-900">
                      {{ tasksByStatus.in_progress }}
                    </span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-2">
                    <div
                      class="bg-blue-500 h-2 rounded-full transition-all"
                      :style="{
                        width: tasksCount > 0
                          ? (tasksByStatus.in_progress / tasksCount * 100) + '%'
                          : '0%'
                      }"
                    ></div>
                  </div>
                </div>

                <!-- Completadas -->
                <div>
                  <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700">Completadas</span>
                    <span class="text-sm font-bold text-gray-900">
                      {{ tasksByStatus.completed }}
                    </span>
                  </div>
                  <div class="w-full bg-gray-200 rounded-full h-2">
                    <div
                      class="bg-green-500 h-2 rounded-full transition-all"
                      :style="{
                        width: tasksCount > 0
                          ? (tasksByStatus.completed / tasksCount * 100) + '%'
                          : '0%'
                      }"
                    ></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Mis Tareas Próximas -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-gray-900 mb-6">
                Mis Tareas Próximas
              </h3>

              <div v-if="myTasks.length > 0" class="space-y-3">
                <Link
                  v-for="task in myTasks"
                  :key="task.id"
                  :href="route('tasks.show', task.id)"
                  class="block p-3 bg-gray-50 hover:bg-gray-100 rounded transition"
                >
                  <p class="font-medium text-gray-900 text-sm">{{ task.name }}</p>
                  <p class="text-xs text-gray-600 mt-1">
                    {{ task.project?.name }}
                  </p>
                  <p v-if="task.due_date" class="text-xs text-gray-500 mt-1">
                    📅 {{ formatDate(task.due_date) }}
                  </p>
                </Link>
              </div>
              <div v-else class="text-center py-6 text-gray-500">
                <p class="text-sm">No tienes tareas asignadas</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Equipos Recientes -->
        <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">
              Tus Equipos
            </h3>

            <div v-if="recentTeams.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <Link
                v-for="team in recentTeams"
                :key="team.id"
                :href="route('teams.show', team.id)"
                class="p-4 border border-gray-200 rounded-lg hover:border-indigo-300 hover:shadow transition"
              >
                <h4 class="font-semibold text-gray-900 mb-2">{{ team.name }}</h4>
                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                  {{ team.description || 'Sin descripción' }}
                </p>
                <p class="text-xs text-gray-500">
                  📁 {{ team.projects?.length || 0 }} proyectos
                </p>
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
import { Head, Link } from '@inertiajs/vue3';

interface Project {
  id: number;
  name: string;
}

interface Task {
  id: number;
  name: string;
  due_date: string | null;
  project?: Project;
}

interface Team {
  id: number;
  name: string;
  description: string | null;
  projects?: Project[];
}

defineProps<{
  teamsCount: number;
  projectsCount: number;
  tasksCount: number;
  tasksByStatus: {
    pending: number;
    in_progress: number;
    completed: number;
  };
  myTasks: Task[];
  recentTeams: Team[];
}>();

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
