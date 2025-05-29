<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import NavIcon from '../components/NavIcon.vue'

const route = useRoute()
const router = useRouter()
const menuOpen = ref(false)

function logout() {
  localStorage.removeItem('token')
  router.push('/login')
}
</script>

<template>
  <div class="w-screen h-screen overflow-hidden flex flex-col bg-white">
    <header class="fixed top-0 left-0 w-full z-10 bg-blue-600 text-white p-5 flex justify-between items-center shadow-xl rounded-b-2xl md:rounded-none">
      <h1 class="font-medium text-xl">Chat App</h1>

      <!-- Desktop Icons -->
      <div class="hidden md:flex items-center space-x-4">
        <router-link to="/add-friends" title="Add Friends">
          <i class="fas fa-user-plus text-xl cursor-pointer hover:text-gray-300"></i>
        </router-link>
        <router-link to="/friend-requests" title="Friend Requests">
          <i class="fas fa-user-clock text-xl cursor-pointer hover:text-gray-300"></i>
        </router-link>
        <router-link to="/friends" title="Friends">
          <i class="fas fa-user-friends text-xl cursor-pointer hover:text-gray-300"></i>
        </router-link>
        <button @click="logout" title="Logout">
          <i class="fas fa-sign-out-alt text-2xl cursor-pointer hover:text-gray-300"></i>
        </button>
      </div>

      <!-- Mobile Hamburger -->
      <div class="md:hidden">
        <button @click="menuOpen = true">
          <i class="fas fa-bars text-2xl hover:text-gray-300"></i>
        </button>
      </div>
    </header>

    <!-- Fullscreen Mobile Menu Overlay -->
    <div
      v-if="menuOpen"
      class="fixed inset-0 bg-white z-50 flex flex-col items-center justify-center text-black text-lg"
    >
      <button class="absolute top-5 right-5 text-3xl" @click="menuOpen = false">
        <i class="fas fa-times text-blue-600"></i>
      </button>

      <router-link
        to="/add-friends"
        class="mb-6 text-xl"
        @click="menuOpen = false"
      >👤 Add Friends</router-link>

      <router-link
        to="/friend-requests"
        class="mb-6 text-xl"
        @click="menuOpen = false"
      >⏳ Friend Requests</router-link>

      <router-link
        to="/friends"
        class="mb-6 text-xl"
        @click="menuOpen = false"
      >👥 Friends</router-link>

      <button
        @click="() => { menuOpen = false; logout(); }"
        class="text-red-600 text-xl"
      >🚪 Logout</button>
    </div>

    <!-- Main Layout -->
    <div class="flex flex-1 h-full py-16 md:py-0 md:pt-16 md:mb-0 overflow-y-auto">
      <aside class="hidden md:flex flex-col w-[6%] bg-gray-100 py-4 items-center space-y-6">
        <NavIcon label="Chats" :active="route.path === '/chats'" />
        <NavIcon label="Groups" :active="route.path === '/groups'" />
        <NavIcon label="Profile" :active="route.path === '/profile'" />
        <NavIcon label="More" :active="route.path === '/more'" />
      </aside>

      <main class="flex-1 flex w-full h-[calc(97%)] md:h-full md:w-[94%]">
        <router-view />
      </main>
    </div>

    <footer class="block md:hidden fixed bottom-0 left-0 w-full bg-white flex justify-around py-2 z-10 rounded-t-2xl shadow-top">
      <NavIcon label="Chats" :active="route.path === '/chats'" />
      <NavIcon label="Groups" :active="route.path === '/groups'" />
      <NavIcon label="Profile" :active="route.path === '/profile'" />
      <NavIcon label="More" :active="route.path === '/more'" />
    </footer>
  </div>
</template>
