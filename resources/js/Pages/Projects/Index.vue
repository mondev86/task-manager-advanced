<template>
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Proyectos: {{ team.name }}
                </h2>
                <Link
                    v-if="isAdmin"
                    :href="route('projects.create', { team: team.id })"
                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-indigo-700"
                >
                    + Crear Proyecto
                </Link>
            </div>
        </template>

        <Head :title="`Proyectos: ${team.name}`" />

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Si no hay proyectos -->
                <div
                    v-if="projects.data.length === 0"
                    class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg"
                >
                    <p class="text-center text-gray-500">
                        No hay proyectos en este equipo
                    </p>
                </div>

                <!-- Grid de proyectos -->
                <div
                    v-else
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
                >
                    <div
                        v-for="project in projects.data"
                        :key="project.id"
                        class="overflow-hidden bg-white p-6 shadow-sm transition-shadow hover:shadow-lg sm:rounded-lg"
                    >
                        <!-- Nombre -->
                        <h3 class="mb-2 text-lg font-bold text-gray-900">
                            {{ project.name }}
                        </h3>

                        <!-- Descripción -->
                        <p class="mb-4 line-clamp-2 text-sm text-gray-600">
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
                                class="inline-flex flex-1 items-center justify-center rounded-md border border-transparent bg-indigo-600 px-3 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-indigo-700"
                            >
                                Ver
                            </Link>
                            <Link
                                v-if="isAdmin"
                                :href="route('projects.edit', project.id)"
                                class="inline-flex flex-1 items-center justify-center rounded-md border border-transparent bg-gray-600 px-3 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700"
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

defineProps<{
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
