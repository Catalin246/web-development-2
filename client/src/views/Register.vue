<template>
  <div class="flex items-center justify-center min-h-screen bg-white">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
      <h2 class="text-2xl font-semibold mb-4 text-center">Register</h2>
      <form @submit.prevent="handleRegister">
        <input
          v-model="name"
          type="text"
          placeholder="Name"
          class="w-full p-2 border rounded mb-3"
        />
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          class="w-full p-2 border rounded mb-3"
        />
        <input
          v-model="password"
          type="password"
          placeholder="Password"
          class="w-full p-2 border rounded mb-4"
        />
        <button type="submit" class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-600">
          Register
        </button>
      </form>
      <p class="text-sm text-center mt-4">
        Already have an account?
        <router-link to="/login" class="text-blue-500">Login</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const name = ref('')
const email = ref('')
const password = ref('')

function handleRegister() {
  // TODO: Replace with real registration logic
  if (name.value && email.value && password.value) {
    router.push('/chats')
  }
}
</script>
