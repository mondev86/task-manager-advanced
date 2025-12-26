<template>
  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ task.title }}
        </h2>
        <div class="flex gap-2">
          <Link
            v-if="userIsAdmin"
            :href="route('tasks.edit', task.id)"
            class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 transition"
          >
            Editar
          </Link>
          <Link
            :href="route('projects.show', task.project_id)"
            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition"
          >
            Volver
          </Link>
        </div>
      </div>
    </template>

    <Head :title="`Tarea: ${task.title}`" />

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <!-- Información principal -->
            <div class="mb-8">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Información de la Tarea
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nombre
                  </label>
                  <p class="text-gray-900">{{ task.title }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Estado
                  </label>
                  <p :class="getStatusClass(task.status)">
                    {{ formatStatus(task.status) }}
                  </p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Prioridad
                  </label>
                  <p :class="getPriorityClass(task.priority)">
                    {{ formatPriority(task.priority) }}
                  </p>
                </div>
                <div v-if="task.due_date">
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Fecha de Entrega
                  </label>
                  <p class="text-gray-900">{{ formatDate(task.due_date) }}</p>
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción
                  </label>
                  <p class="text-gray-900">
                    {{ task.description || 'Sin descripción' }}
                  </p>
                </div>
              </div>
            </div>

            <!-- Metadatos -->
            <div class="border-t pt-8 mb-8">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Detalles
              </h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Proyecto
                  </label>
                  <Link
                    :href="route('projects.show', task.project_id)"
                    class="text-indigo-600 hover:text-indigo-700 underline"
                  >
                    {{ task.project?.name }}
                  </Link>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Creada por
                  </label>
                  <p class="text-gray-900">{{ task.created_by_user?.name }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Asignada a
                  </label>
                  <p class="text-gray-900">
                    {{ task.assigned_user?.name || 'No asignada' }}
                  </p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">
                    Creada
                  </label>
                  <p class="text-gray-900">{{ formatDate(task.created_at) }}</p>
                </div>
              </div>
            </div>

            <!-- Comentarios -->
            <div class="border-t pt-8">
              <h3 class="text-lg font-semibold text-gray-800 mb-4">
                Comentarios ({{ task.comments?.length || 0 }})
              </h3>

              <!-- Formulario de nuevo comentario -->
              <form @submit.prevent="submitComment" class="mb-6">
                <div class="mb-4">
                  <textarea
                    v-model="commentForm.content"
                    placeholder="Añade un comentario..."
                    maxlength="1000"
                    class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none transition resize-none"
                    rows="3"
                  ></textarea>
                  <p v-if="commentForm.errors.content" class="text-sm text-red-600 mt-1">
                    {{ commentForm.errors.content }}
                  </p>
                  <div class="flex justify-between items-center mt-2">
                    <button
                      type="submit"
                      :disabled="commentForm.processing"
                      class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                      <span v-if="commentForm.processing">Enviando...</span>
                      <span v-else>Comentar</span>
                    </button>
                    <span class="text-xs text-gray-500">
                      {{ commentForm.content.length }}/1000
                    </span>
                  </div>
                </div>
              </form>

              <!-- Lista de comentarios -->
              <div v-if="task.comments && task.comments.length > 0" class="space-y-4">
                <div
                  v-for="comment in task.comments"
                  :key="comment.id"
                  class="p-4 bg-gray-50 rounded-md"
                >
                  <div class="flex justify-between items-start mb-2">
                    <div>
                      <p class="font-medium text-gray-900">{{ comment.user?.name }}</p>
                      <p class="text-xs text-gray-500">
                        {{ formatDate(comment.created_at) }}
                      </p>
                    </div>
                    <button
                      v-if="canDeleteComment(comment)"
                      @click="deleteComment(comment.id)"
                      class="text-red-600 hover:text-red-700 text-sm"
                    >
                      ✕
                    </button>
                  </div>
                  <p class="text-gray-700 text-sm">{{ comment.content }}</p>
                </div>
              </div>
              <div v-else class="text-center py-6 text-gray-500">
                <p class="text-sm">No hay comentarios aún</p>
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
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

interface User {
  id: number;
  name: string;
  email: string;
}

interface Project {
  id: number;
  name: string;
}

interface Comment {
  id: number;
  content: string;
  created_at: string;
  user?: User;
}

interface Task {
  id: number;
  title: string;
  description: string | null;
  status: 'pending' | 'in_progress' | 'completed';
  priority: 'low' | 'medium' | 'high';
  due_date: string | null;
  project_id: number;
  created_at: string;
  project?: Project;
  created_by_user?: User;
  assigned_user?: User;
  comments?: Comment[];
}

const props = defineProps<{
  task: Task;
  userIsAdmin: boolean;
}>();

const page = usePage();

const commentForm = useForm({
  content: '',
});

const submitComment = (): void => {
  commentForm.post(route('comments.store', props.task.id), {
    onSuccess: () => {
      commentForm.reset();
    },
  });
};

const canDeleteComment = (comment: Comment): boolean => {
  const userId = page.props.auth?.user?.id;
  return userId === comment.user?.id || props.userIsAdmin;
};

const deleteComment = (commentId: number): void => {
  if (confirm('¿Estás seguro de que deseas eliminar este comentario?')) {
    useForm({}).delete(route('comments.destroy', commentId));
  }
};

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
    pending: 'px-2 py-1 bg-gray-100 text-gray-700 rounded inline-block',
    in_progress: 'px-2 py-1 bg-blue-100 text-blue-700 rounded inline-block',
    completed: 'px-2 py-1 bg-green-100 text-green-700 rounded inline-block',
  };
  return classes[status] || 'px-2 py-1 bg-gray-100 text-gray-700 rounded inline-block';
};

const getPriorityClass = (priority: string) => {
  const classes: Record<string, string> = {
    low: 'px-2 py-1 bg-blue-100 text-blue-700 rounded inline-block',
    medium: 'px-2 py-1 bg-yellow-100 text-yellow-700 rounded inline-block',
    high: 'px-2 py-1 bg-red-100 text-red-700 rounded inline-block',
  };
  return classes[priority] || 'px-2 py-1 bg-gray-100 text-gray-700 rounded inline-block';
};

const formatDate = (date: string) => {
  return new Date(date).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};
</script>

<style scoped>
textarea {
  font-family: inherit;
}
</style>
