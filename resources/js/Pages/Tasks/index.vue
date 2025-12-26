<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Tareas: {{ project.name }}
        </h2>
        <Link
          v-if="userIsAdmin"
          :href="route('tasks.create', { project: project.id })"
          class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition"
        >
          + Nueva Tarea
        </Link>
      </div>
    </template>

    <Head :title="`Tareas: ${project.name}`" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Si no hay tareas -->
        <div v-if="tasks.data.length === 0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
          <p class="text-gray-500 text-center">No hay tareas en este proyecto</p>
        </div>

        <!-- Lista de tareas -->
        <div v-else class="space-y-3">
          <div
            v-for="task in tasks.data"
            :key="task.id"
            class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 hover:shadow-md transition-shadow"
          >
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <Link
                  :href="route('tasks.show', task.id)"
                  class="text-lg font-semibold text-indigo-600 hover:text-indigo-700 mb-2"
                >
                  {{ task.name }}
                </Link>

                <p class="text-gray-600 text-sm mb-3">
                  {{ task.description || 'Sin descripción' }}
                </p>

                <div class="flex gap-4 text-sm text-gray-500">
                  <span :class="getStatusClass(task.status)">
                    {{ formatStatus(task.status) }}
                  </span>
                  <span :class="getPriorityClass(task.priority)">
                    {{ formatPriority(task.priority) }}
                  </span>
                  <span v-if="task.due_date">
                    📅 {{ formatDate(task.due_date) }}
                  </span>
                </div>
              </div>

              <div class="flex gap-2 ml-4">
                <Link
                  v-if="userIsAdmin"
                  :href="route('tasks.edit', task.id)"
                  class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded text-sm hover:bg-yellow-200 transition"
                >
                  Editar
                </Link>
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

interface Task {
  id: number;
  name: string;
  description: string | null;
  status: 'pending' | 'in_progress' | 'completed';
  priority: 'low' | 'medium' | 'high';
  due_date: string | null;
}

interface PaginatedTasks {
  data: Task[];
}

interface Project {
  id: number;
  name: string;
}

defineProps<{
  project: Project;
  tasks: PaginatedTasks;
  userIsAdmin: boolean;
}>();

const formatStatus = (status: string) => {
  const map: Record<string, string> = {
    pending: 'Pendiente',
    in_progress: 'En progreso',
    completed: 'Completada',
  };
  return map[status] || status;
};

const formatPriority = (priority: string) => {
  const map: Record<string, string> = {
    low: 'Baja',
    medium: 'Media',
    high: 'Alta',
  };
  return map[priority] || priority;
};

const getStatusClass = (status: string) => {
  const classes: Record<string, string> = {
    pending: 'px-2 py-1 bg-gray-100 text-gray-700 rounded',
    in_progress: 'px-2 py-1 bg-blue-100 text-blue-700 rounded',
    completed: 'px-2 py-1 bg-green-100 text-green-700 rounded',
  };
  return classes[status] || 'px-2 py-1 bg-gray-100 text-gray-700 rounded';
};

const getPriorityClass = (priority: string) => {
  const classes: Record<string, string> = {
    low: 'px-2 py-1 bg-blue-100 text-blue-700 rounded',
    medium: 'px-2 py-1 bg-yellow-100 text-yellow-700 rounded',
    high: 'px-2 py-1 bg-red-100 text-red-700 rounded',
  };
  return classes[priority] || 'px-2 py-1 bg-gray-100 text-gray-700 rounded';
};

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
};
</script>
