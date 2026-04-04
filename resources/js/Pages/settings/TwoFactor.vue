<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Autenticación de Dos Factores
            </h2>
        </template>

        <Head title="Autenticación de Dos Factores" />

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <div class="flex items-center">
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
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                ></path>
                            </svg>
                            <h3 class="ml-2 text-lg font-medium text-gray-900">
                                Autenticación de Dos Factores
                            </h3>
                        </div>
                    </div>

                    <div class="bg-gray-50 bg-opacity-50 p-6">
                        <div v-if="!twoFactorEnabled" class="text-center">
                            <p class="mb-4 text-gray-600">
                                Agregue seguridad adicional a su cuenta
                                habilitando la autenticación de dos factores.
                            </p>
                            <button
                                @click="enable"
                                class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-indigo-700"
                            >
                                Habilitar 2FA
                            </button>
                        </div>

                        <div v-else class="space-y-6">
                            <div class="text-center">
                                <div
                                    class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800"
                                >
                                    <svg
                                        class="mr-1 h-4 w-4"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                    2FA Habilitado
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-6">
                                <h4
                                    class="mb-4 text-lg font-medium text-gray-900"
                                >
                                    Códigos de Recuperación
                                </h4>
                                <p class="mb-4 text-gray-600">
                                    Guarde estos códigos de recuperación en un
                                    lugar seguro. Puede usarlos para acceder a
                                    su cuenta si pierde su dispositivo de
                                    autenticación de dos factores.
                                </p>
                                <button
                                    @click="
                                        showRecoveryCodes = !showRecoveryCodes
                                    "
                                    class="inline-flex items-center rounded-md border border-transparent bg-gray-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700"
                                >
                                    {{
                                        showRecoveryCodes
                                            ? 'Ocultar'
                                            : 'Mostrar'
                                    }}
                                    Códigos de Recuperación
                                </button>

                                <div
                                    v-if="showRecoveryCodes"
                                    class="mt-4 rounded-md bg-gray-100 p-4"
                                >
                                    <p class="mb-2 text-sm text-gray-600">
                                        Códigos de recuperación:
                                    </p>
                                    <div
                                        class="grid grid-cols-2 gap-2 font-mono text-sm"
                                    >
                                        <div
                                            v-for="code in recoveryCodes"
                                            :key="code"
                                            class="rounded border bg-white p-2"
                                        >
                                            {{ code }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-6">
                                <h4
                                    class="mb-4 text-lg font-medium text-gray-900"
                                >
                                    Deshabilitar 2FA
                                </h4>
                                <p class="mb-4 text-gray-600">
                                    Si ya no desea usar la autenticación de dos
                                    factores, puede deshabilitarla aquí.
                                </p>
                                <button
                                    @click="disable"
                                    class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-700"
                                >
                                    Deshabilitar 2FA
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
import { Head, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();

defineProps<{
    twoFactorEnabled: boolean;
    requiresConfirmation: boolean;
}>();

const showRecoveryCodes = ref(false);
const enabling = ref(false);
const disabling = ref(false);

const recoveryCodes = computed(() => {
    const codes = page.props.recoveryCodes;
    if (Array.isArray(codes) && codes.length > 0) {
        return codes;
    }
    return [];
});

const enable = () => {
    enabling.value = true;
    router.post(
        '/user/two-factor-authentication',
        {},
        {
            onFinish: () => {
                enabling.value = false;
            },
        },
    );
};

const disable = () => {
    if (
        confirm(
            '¿Estás seguro de que deseas deshabilitar la autenticación de dos factores?',
        )
    ) {
        disabling.value = true;
        router.delete('/user/two-factor-authentication', {
            onFinish: () => {
                disabling.value = false;
            },
        });
    }
};
</script>
