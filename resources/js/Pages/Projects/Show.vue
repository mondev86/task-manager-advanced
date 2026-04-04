<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ project.name }}
                </h2>
                <div class="flex gap-2">
                    <Link
                        :href="`/projects/${project.id}/tasks/create`"
                        class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700"
                    >
                        + Crear Tarea
                    </Link>
                    <Link
                        :href="route('projects.edit', project.id)"
                        class="inline-flex items-center rounded-md border border-transparent bg-gray-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700"
                    >
                        Editar
                    </Link>
                    <button
                        @click="deleteProject"
                        class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-700"
                    >
                        Eliminar
                    </button>
                    <Link
                        :href="route('teams.show', project.team.id)"
                        class="inline-flex items-center rounded-md border border-transparent bg-gray-400 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-500"
                    >
                        Volver
                    </Link>
                </div>
            </div>
        </template>

        <Head :title="`Proyecto: ${project.name}`" />

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- Información del proyecto -->
                <div
                    class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg"
                >
                    <h3 class="mb-2 text-lg font-bold text-gray-900">
                        Información
                    </h3>
                    <p class="text-gray-600">
                        {{ project.description || 'Sin descripción' }}
                    </p>
                    <div class="mt-4 text-sm text-gray-500">
                        <p><strong>Equipo:</strong> {{ project.team.name }}</p>
                        <p>
                            <strong>Tareas:</strong> {{ project.tasks.length }}
                        </p>
                    </div>
                </div>

                <!-- Filtros de tareas -->
                <div
                    class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg"
                >
                    <h3 class="mb-4 text-lg font-bold text-gray-900">
                        Filtros
                    </h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <button
                            @click="selectedStatus = null"
                            :class="[
                                'rounded-md px-4 py-2 text-sm font-semibold transition duration-150 ease-in-out',
                                selectedStatus === null
                                    ? 'bg-indigo-600 text-white'
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300',
                            ]"
                        >
                            Todas ({{ project.tasks.length }})
                        </button>
                        <button
                            @click="selectedStatus = 'pending'"
                            :class="[
                                'rounded-md px-4 py-2 text-sm font-semibold transition duration-150 ease-in-out',
                                selectedStatus === 'pending'
                                    ? 'bg-red-600 text-white'
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300',
                            ]"
                        >
                            Pendientes ({{ countByStatus('pending') }})
                        </button>
                        <button
                            @click="selectedStatus = 'in_progress'"
                            :class="[
                                'rounded-md px-4 py-2 text-sm font-semibold transition duration-150 ease-in-out',
                                selectedStatus === 'in_progress'
                                    ? 'bg-yellow-600 text-white'
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300',
                            ]"
                        >
                            En Progreso ({{ countByStatus('in_progress') }})
                        </button>
                        <button
                            @click="selectedStatus = 'completed'"
                            :class="[
                                'rounded-md px-4 py-2 text-sm font-semibold transition duration-150 ease-in-out',
                                selectedStatus === 'completed'
                                    ? 'bg-green-600 text-white'
                                    : 'bg-gray-200 text-gray-700 hover:bg-gray-300',
                            ]"
                        >
                            Completadas ({{ countByStatus('completed') }})
                        </button>
                    </div>
                </div>

                <!-- Lista de tareas -->
                <div
                    class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg"
                >
                    <h3 class="mb-4 text-lg font-bold text-gray-900">Tareas</h3>

                    <div
                        v-if="filteredTasks.length === 0"
                        class="py-8 text-center text-gray-500"
                    >
                        No hay tareas
                        {{ selectedStatus ? 'en este estado' : '' }}
                    </div>

                    <div v-else class="space-y-4">
                        <div
                            v-for="task in filteredTasks"
                            :key="task.id"
                            class="rounded-lg border border-gray-200 p-4 transition-shadow hover:shadow-md"
                        >
                            <!-- Encabezado de la tarea -->
                            <div class="mb-3 flex items-start justify-between">
                                <div class="flex-1">
                                    <Link
                                        :href="route('tasks.show', task.id)"
                                        class="text-lg font-bold text-indigo-600 hover:text-indigo-700"
                                    >
                                        {{ task.name }}
                                    </Link>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{
                                            task.description ||
                                            'Sin descripción'
                                        }}
                                    </p>
                                </div>

                                <!-- Selector de estado -->
                                <select
                                    :value="task.status"
                                    @change="
                                        updateTaskStatus(
                                            task.id,
                                            ($event.target as HTMLSelectElement)
                                                .value,
                                        )
                                    "
                                    :class="[
                                        'ml-4 rounded-md border-0 px-3 py-1 text-xs font-semibold text-white focus:outline-none',
                                        task.status === 'completed'
                                            ? 'bg-green-600'
                                            : task.status === 'in_progress'
                                              ? 'bg-yellow-600'
                                              : 'bg-red-600',
                                    ]"
                                >
                                    <option value="pending">Pendiente</option>
                                    <option value="in_progress">
                                        En Progreso
                                    </option>
                                    <option value="completed">
                                        Completada
                                    </option>
                                </select>
                            </div>

                            <!-- Meta información -->
                            <div
                                class="mb-3 flex flex-wrap gap-4 text-sm text-gray-600"
                            >
                                <!-- Prioridad -->
                                <div>
                                    <span
                                        class="rounded px-2 py-1 text-xs font-semibold"
                                        :class="{
                                            'bg-red-100 text-red-800':
                                                task.priority === 'high',
                                            'bg-orange-100 text-orange-800':
                                                task.priority === 'medium',
                                            'bg-blue-100 text-blue-800':
                                                task.priority === 'low',
                                        }"
                                    >
                                        {{ priorityLabel(task.priority) }}
                                    </span>
                                </div>

                                <!-- Fecha límite -->
                                <div
                                    v-if="task.due_date"
                                    class="flex items-center gap-1"
                                >
                                    <span>📅</span>
                                    <span>{{ formatDate(task.due_date) }}</span>
                                </div>

                                <!-- Asignado a -->
                                <div
                                    v-if="task.assignedTo"
                                    class="flex items-center gap-2"
                                >
                                    <div
                                        class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100"
                                    >
                                        <span
                                            class="text-xs font-bold text-indigo-600"
                                        >
                                            {{
                                                task.assignedTo.name
                                                    .charAt(0)
                                                    .toUpperCase()
                                            }}
                                        </span>
                                    </div>
                                    <span>{{ task.assignedTo.name }}</span>
                                </div>
                            </div>

                            <!-- Botones de acción -->
                            <div class="flex gap-2">
                                <Link
                                    :href="route('tasks.show', task.id)"
                                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700"
                                >
                                    Ver Detalles
                                </Link>
                                <Link
                                    :href="route('tasks.edit', task.id)"
                                    class="inline-flex items-center rounded-md border border-transparent bg-gray-600 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700"
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
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface User {
    id: number;
    name: string;
}

interface Team {
    id: number;
    name: string;
}

interface Task {
    id: number;
    name: string;
    description: string | null;
    status: 'pending' | 'in_progress' | 'completed';
    priority: 'low' | 'medium' | 'high';
    due_date: string | null;
    assignedTo?: User;
}

interface Project {
    id: number;
    name: string;
    description: string | null;
    team: Team;
    tasks: Task[];
}

const props = defineProps<{
    project: Project;
}>();

const selectedStatus = ref<string | null>(null);

const filteredTasks = computed(() => {
    if (!selectedStatus.value) {
        return props.project.tasks;
    }
    return props.project.tasks.filter(
        (task: Task) => task.status === selectedStatus.value,
    );
});

const countByStatus = (status: string) => {
    return props.project.tasks.filter((task: Task) => task.status === status)
        .length;
};

const priorityLabel = (priority: string) => {
    const labels: Record<string, string> = {
        low: 'Baja',
        medium: 'Media',
        high: 'Alta',
    };
    return labels[priority] || priority;
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const updateTaskStatus = (taskId: number, status: string) => {
    router.patch(route('tasks.update', taskId), { status });
};

const deleteProject = (): void => {
    if (confirm('¿Estás seguro de que deseas eliminar este proyecto?')) {
        useForm({}).delete(route('projects.destroy', props.project.id));
    }
};
</script>
