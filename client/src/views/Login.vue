<template>
  <div class="flex items-center justify-center min-h-screen bg-">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-md">
      <h2 class="text-2xl font-semibold mb-4 text-center">Login</h2>
      <form @submit.prevent="handleLogin">
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
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
          Log In
        </button>
      </form>
      <p class="text-sm text-center mt-4">
        Don't have an account?
        <router-link to="/register" class="text-blue-500">Register</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const email = ref('')
const password = ref('')

// Getting the API URL from the environment variable
const apiUrl = import.meta.env.VITE_API_URL;
console.log(apiUrl);

// Function to handle login
async function handleLogin() {
  if (email.value && password.value) {
    try {
      const response = await fetch(`${apiUrl}/auth/login`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: email.value,
          password: password.value,
        }),
      });

      if (!response.ok) {
        throw new Error('Login failed');
      }

      // Parse the response JSON
      const data = await response.json();

      // Check if a token is returned in the response
      if (data.token) {
        // Store the token (example: localStorage or Vuex store)
        localStorage.setItem('token', data.token);

        // Redirect to the chats page after successful login
        router.push('/chats');
      } else {
        throw new Error('Token not found in response');
      }
    } catch (error) {
      console.error('Login Error:', error);
      // Handle the error (you can show a message to the user here)
    }
  } else {
    console.error('Email or password is empty');
    // You can add a validation error here if needed
  }
}
</script>
