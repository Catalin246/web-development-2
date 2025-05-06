<script setup>
import { useRoute } from 'vue-router'
import NavIcon from './components/NavIcon.vue'

const route = useRoute()
</script>

<template>
  <div class="w-screen h-screen overflow-hidden flex flex-col bg-white">

    <!-- Fixed Header -->
    <header class="fixed top-0 left-0 w-full z-10 bg-blue-600 text-white p-5 flex justify-between items-center shadow-xl rounded-b-2xl md:rounded-none">
      <h1 class="font-medium text-xl">Chat App</h1>
    </header>

    <!-- Main Layout with Scroll -->
    <div class="flex flex-1 h-full py-16 md:py-0 md:pt-16 md:mb-0 overflow-y-auto"> <!-- adjust mt and mb to match header/footer height -->

      <!-- Sidebar (10%) -->
      <aside class="hidden md:flex flex-col w-[6%] bg-gray-100 py-4 items-center space-y-6">
        <NavIcon label="Chats" :active="route.path === '/chats'" />
        <NavIcon label="Groups" :active="route.path === '/groups'" />
        <NavIcon label="Profile" :active="route.path === '/profile'" />
        <NavIcon label="More" :active="route.path === '/more'" />
      </aside>

      <!-- Page Content -->
      <main class="flex-1 flex w-full md:w-[94%]">
        <router-view />
      </main>
    </div>

    <!-- Fixed Mobile Bottom Nav -->
    <footer class="block md:hidden fixed bottom-0 left-0 w-full bg-white flex justify-around py-2 z-10 rounded-t-2xl shadow-top">
      <NavIcon label="Chats" :active="route.path === '/chats'" />
      <NavIcon label="Groups" :active="route.path === '/groups'" />
      <NavIcon label="Profile" :active="route.path === '/profile'" />
      <NavIcon label="More" :active="route.path === '/more'" />
  </footer>
  </div>
</template>
