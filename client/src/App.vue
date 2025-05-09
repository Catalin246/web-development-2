<!-- App.vue -->
<script setup>
import { useRoute, onBeforeRouteUpdate } from 'vue-router'
import { watchEffect, onMounted } from 'vue'

const route = useRoute()

const updateBodyClass = () => {
  const isAuthPage = route.path === '/login' || route.path === '/register'
  document.body.classList.toggle('auth-page', isAuthPage)
}

onMounted(updateBodyClass)
watchEffect(updateBodyClass)
</script>

<template>
  <router-view />
</template>
