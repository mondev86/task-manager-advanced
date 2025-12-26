<template>
  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-indigo-50">
    <Head title="TaskManager - Sistema de Gestión de Tareas" />

    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="text-2xl font-bold text-indigo-600">
            📋 TaskManager
          </div>
          <div class="flex gap-4">
            <Link
              v-if="canLogin"
              :href="route('login')"
              class="px-4 py-2 text-indigo-600 hover:text-indigo-700 font-semibold"
            >
              Iniciar Sesión
            </Link>
            <Link
              v-if="canRegister"
              :href="route('register')"
              class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold"
            >
              Registrarse
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
      <div class="text-center">
        <h1 class="text-5xl font-bold text-gray-900 mb-6">
          Gestiona tu equipo con <span class="text-indigo-600">TaskManager</span>
        </h1>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
          La herramienta perfecta para organizar equipos, proyectos y tareas. Colabora en tiempo real y alcanza tus objetivos.
        </p>
        <div class="flex gap-4 justify-center">
          <Link
            v-if="canRegister"
            :href="route('register')"
            class="px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold transition"
          >
            Comienza Gratis
          </Link>
          <Link
            v-if="canLogin"
            :href="route('login')"
            class="px-8 py-3 border-2 border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-50 font-semibold transition"
          >
            Inicia Sesión
          </Link>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="bg-white py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-16">
          Características
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Feature 1 -->
          <div class="p-6 border border-gray-200 rounded-lg hover:shadow-lg transition">
            <div class="text-4xl mb-4">👥</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Gestión de Equipos</h3>
            <p class="text-gray-600">
              Crea y organiza equipos de trabajo. Invita a miembros y colabora sin límites.
            </p>
          </div>

          <!-- Feature 2 -->
          <div class="p-6 border border-gray-200 rounded-lg hover:shadow-lg transition">
            <div class="text-4xl mb-4">📁</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Proyectos Organizados</h3>
            <p class="text-gray-600">
              Agrupa tareas en proyectos. Mantén todo organizado y fácil de seguir.
            </p>
          </div>

          <!-- Feature 3 -->
          <div class="p-6 border border-gray-200 rounded-lg hover:shadow-lg transition">
            <div class="text-4xl mb-4">✅</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Gestión de Tareas</h3>
            <p class="text-gray-600">
              Crea, asigna y monitorea tareas. Establece prioridades y fechas límite.
            </p>
          </div>

          <!-- Feature 4 -->
          <div class="p-6 border border-gray-200 rounded-lg hover:shadow-lg transition">
            <div class="text-4xl mb-4">💬</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Colaboración en Tiempo Real</h3>
            <p class="text-gray-600">
              Comenta en tareas y comunícate con tu equipo instantáneamente.
            </p>
          </div>

          <!-- Feature 5 -->
          <div class="p-6 border border-gray-200 rounded-lg hover:shadow-lg transition">
            <div class="text-4xl mb-4">🎯</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Prioridades y Estados</h3>
            <p class="text-gray-600">
              Filtra tareas por estado, prioridad y asignado. Visualiza el progreso.
            </p>
          </div>

          <!-- Feature 6 -->
          <div class="p-6 border border-gray-200 rounded-lg hover:shadow-lg transition">
            <div class="text-4xl mb-4">📅</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Fechas de Vencimiento</h3>
            <p class="text-gray-600">
              Establece fechas límite y no pierdas ningún plazo importante.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-indigo-600 py-20">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">
          ¿Listo para mejorar tu productividad?
        </h2>
        <p class="text-xl text-indigo-100 mb-8">
          Únete a miles de equipos que ya usan TaskManager para gestionar sus proyectos.
        </p>
        <Link
          v-if="canRegister"
          :href="route('register')"
          class="inline-block px-8 py-3 bg-white text-indigo-600 rounded-lg hover:bg-gray-100 font-semibold transition"
        >
          Registrarse Ahora
        </Link>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p>© 2025 TaskManager. Todos los derechos reservados.</p>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

interface Props {
  canLogin: boolean;
  canRegister: boolean;
  laravelVersion: string;
  phpVersion: string;
}

defineProps<Props>();
</script>

<style scoped>
/* Estilos personalizados si es necesario */
</style>
