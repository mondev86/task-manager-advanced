<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Autenticación de Dos Factores
      </h2>
    </template>

    <Head title="Autenticación de Dos Factores" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center">
              <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
              </svg>
              <h3 class="ml-2 text-lg font-medium text-gray-900">
                Autenticación de Dos Factores
              </h3>
            </div>
          </div>

          <div class="bg-gray-50 bg-opacity-50 p-6">
            <div v-if="!twoFactorEnabled" class="text-center">
              <p class="text-gray-600 mb-4">
                Agregue seguridad adicional a su cuenta habilitando la autenticación de dos factores.
              </p>
              <button
                @click="enable"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150"
              >
                Habilitar 2FA
              </button>
            </div>

            <div v-else class="space-y-6">
              <div class="text-center">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                  <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  2FA Habilitado
                </div>
              </div>

              <div class="border-t border-gray-200 pt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Códigos de Recuperación</h4>
                <p class="text-gray-600 mb-4">
                  Guarde estos códigos de recuperación en un lugar seguro. Puede usarlos para acceder a su cuenta si pierde su dispositivo de autenticación de dos factores.
                </p>
                <button
                  @click="showRecoveryCodes = !showRecoveryCodes"
                  class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition ease-in-out duration-150"
                >
                  {{ showRecoveryCodes ? 'Ocultar' : 'Mostrar' }} Códigos de Recuperación
                </button>

                <div v-if="showRecoveryCodes" class="mt-4 p-4 bg-gray-100 rounded-md">
                  <p class="text-sm text-gray-600 mb-2">Códigos de recuperación:</p>
                  <div class="grid grid-cols-2 gap-2 font-mono text-sm">
                    <div v-for="code in recoveryCodes" :key="code" class="bg-white p-2 rounded border">
                      {{ code }}
                    </div>
                  </div>
                </div>
              </div>

              <div class="border-t border-gray-200 pt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Deshabilitar 2FA</h4>
                <p class="text-gray-600 mb-4">
                  Si ya no desea usar la autenticación de dos factores, puede deshabilitarla aquí.
                </p>
                <button
                  @click="disable"
                  class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150"
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
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

// eslint-disable-next-line @typescript-eslint/no-unused-vars
const { twoFactorEnabled, requiresConfirmation } = defineProps<{
  twoFactorEnabled: boolean;
  requiresConfirmation: boolean;
}>();

const showRecoveryCodes = ref(false);
const recoveryCodes = ref([
  '12345678',
  '87654321',
  'abcdef12',
  '21fedcba',
  '34567890',
  '09876543',
  'fedcba98',
  '89abcdef'
]);

const enable = () => {
  // TODO: Implement enable 2FA
  console.log('Enable 2FA');
};

const disable = () => {
  // TODO: Implement disable 2FA
  console.log('Disable 2FA');
};
</script>
