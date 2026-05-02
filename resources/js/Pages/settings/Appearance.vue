<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Apariencia
            </h2>
        </template>

        <Head title="Apariencia" />

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <div class="mb-6 flex items-center">
                            <svg
                                class="h-8 w-8 text-gray-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"
                                ></path>
                            </svg>
                            <h3 class="ml-2 text-lg font-medium text-gray-900">
                                Configuración de Apariencia
                            </h3>
                        </div>
                    </div>

                    <div class="bg-gray-50 bg-opacity-50 p-6">
                        <div class="space-y-6">
                            <div>
                                <label
                                    class="mb-2 block text-sm font-medium text-gray-700"
                                >
                                    Tema de Color
                                </label>
                                <div class="grid grid-cols-3 gap-4">
                                    <button
                                        @click="setTheme('light')"
                                        :class="[
                                            'rounded-lg border-2 p-4 transition-all',
                                            theme === 'light'
                                                ? 'border-indigo-600 bg-indigo-50'
                                                : 'border-gray-200 hover:border-gray-300',
                                        ]"
                                    >
                                        <div
                                            class="mb-2 h-8 w-full rounded border border-gray-200 bg-white"
                                        ></div>
                                        <span class="text-sm font-medium"
                                            >Claro</span
                                        >
                                    </button>
                                    <button
                                        @click="setTheme('dark')"
                                        :class="[
                                            'rounded-lg border-2 p-4 transition-all',
                                            theme === 'dark'
                                                ? 'border-indigo-600 bg-indigo-50'
                                                : 'border-gray-200 hover:border-gray-300',
                                        ]"
                                    >
                                        <div
                                            class="mb-2 h-8 w-full rounded bg-gray-800"
                                        ></div>
                                        <span class="text-sm font-medium"
                                            >Oscuro</span
                                        >
                                    </button>
                                    <button
                                        @click="setTheme('system')"
                                        :class="[
                                            'rounded-lg border-2 p-4 transition-all',
                                            theme === 'system'
                                                ? 'border-indigo-600 bg-indigo-50'
                                                : 'border-gray-200 hover:border-gray-300',
                                        ]"
                                    >
                                        <div
                                            class="mb-2 h-8 w-full rounded border border-gray-200 bg-gradient-to-r from-white to-gray-800"
                                        ></div>
                                        <span class="text-sm font-medium"
                                            >Sistema</span
                                        >
                                    </button>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-6">
                                <label
                                    class="mb-2 block text-sm font-medium text-gray-700"
                                >
                                    Tamaño de Fuente
                                </label>
                                <div class="flex items-center gap-4">
                                    <span class="text-sm text-gray-500">A</span>
                                    <input
                                        type="range"
                                        v-model="fontSize"
                                        min="12"
                                        max="18"
                                        class="h-2 flex-1 cursor-pointer appearance-none rounded-lg bg-gray-200"
                                    />
                                    <span class="text-lg text-gray-500">A</span>
                                    <span class="ml-2 text-sm text-gray-600"
                                        >{{ fontSize }}px</span
                                    >
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-6">
                                <label
                                    class="mb-2 block text-sm font-medium text-gray-700"
                                >
                                    Densidad de Diseño
                                </label>
                                <div class="grid grid-cols-3 gap-4">
                                    <button
                                        @click="density = 'compact'"
                                        :class="[
                                            'rounded-lg border-2 p-4 text-center transition-all',
                                            density === 'compact'
                                                ? 'border-indigo-600 bg-indigo-50'
                                                : 'border-gray-200 hover:border-gray-300',
                                        ]"
                                    >
                                        <span class="text-sm font-medium"
                                            >Compacto</span
                                        >
                                    </button>
                                    <button
                                        @click="density = 'default'"
                                        :class="[
                                            'rounded-lg border-2 p-4 text-center transition-all',
                                            density === 'default'
                                                ? 'border-indigo-600 bg-indigo-50'
                                                : 'border-gray-200 hover:border-gray-300',
                                        ]"
                                    >
                                        <span class="text-sm font-medium"
                                            >Normal</span
                                        >
                                    </button>
                                    <button
                                        @click="density = 'spacious'"
                                        :class="[
                                            'rounded-lg border-2 p-4 text-center transition-all',
                                            density === 'spacious'
                                                ? 'border-indigo-600 bg-indigo-50'
                                                : 'border-gray-200 hover:border-gray-300',
                                        ]"
                                    >
                                        <span class="text-sm font-medium"
                                            >Espacioso</span
                                        >
                                    </button>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-6">
                                <button
                                    @click="saveSettings"
                                    :disabled="saving"
                                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700 disabled:opacity-50"
                                >
                                    {{
                                        saving
                                            ? 'Guardando...'
                                            : 'Guardar Cambios'
                                    }}
                                </button>
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
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const theme = ref('light');
const fontSize = ref(14);
const density = ref('default');
const saving = ref(false);

onMounted(() => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    const savedFontSize = localStorage.getItem('fontSize');
    const savedDensity = localStorage.getItem('density') || 'default';

    theme.value = savedTheme;
    fontSize.value = savedFontSize ? parseInt(savedFontSize) : 14;
    density.value = savedDensity;
});

const setTheme = (newTheme: string) => {
    theme.value = newTheme;
};

const saveSettings = () => {
    saving.value = true;
    localStorage.setItem('theme', theme.value);
    localStorage.setItem('fontSize', fontSize.value.toString());
    localStorage.setItem('density', density.value);
    document.documentElement.classList.remove('dark');
    if (theme.value === 'dark') {
        document.documentElement.classList.add('dark');
    }
    document.documentElement.style.fontSize = `${fontSize.value}px`;
    setTimeout(() => {
        saving.value = false;
    }, 500);
};
</script>
