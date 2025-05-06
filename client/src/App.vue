<script setup>
import { useRoute } from 'vue-router'
import NavIcon from './components/NavIcon.vue'

const route = useRoute()
</script>

<template>
  <div class="min-h-screen w-screen flex flex-col bg-white overflow-hidden">

    <!-- Sticky Header -->
    <header class="sticky top-0 z-10 bg-blue-600 text-white p-4 flex justify-between items-center shadow-md">
      <h1 class="font-medium text-xl">Chat App</h1>
    </header>

    <!-- Main Layout -->
    <div class="flex flex-1 h-full">

      <!-- Sidebar (10%) -->
      <aside class="hidden md:flex flex-col w-[10%] bg-gray-100 py-4 items-center space-y-6">
        <NavIcon label="Chats" :active="route.path === '/chats'" />
        <NavIcon label="Groups" :active="route.path === '/groups'" />
        <NavIcon label="Profile" :active="route.path === '/profile'" />
        <NavIcon label="More" :active="route.path === '/more'" />
      </aside>

      <!-- Page Content -->
      <main class="flex-1 flex w-full md:w-[90%]">
        <router-view />
      </main>
    </div>

    <!-- Mobile Bottom Nav -->
    <footer class="md:hidden sticky bottom-0 bg-white flex justify-around py-2 border-t shadow-md z-10">
      <NavIcon label="Chats" :active="route.path === '/chats'" />
      <NavIcon label="Groups" :active="route.path === '/groups'" />
      <NavIcon label="Profile" :active="route.path === '/profile'" />
      <NavIcon label="More" :active="route.path === '/more'" />
    </footer>
  </div>
</template>
