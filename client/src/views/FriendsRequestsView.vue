<!-- src/views/FriendRequestsView.vue -->
<template>
  <div class="p-4 py-6 md:p-16 md:py-10 w-full">
    <h2 class="text-2xl font-semibold mb-4">Friend Requests</h2>
    <ul class="space-y-2">
      <li v-for="(request, index) in requests" :key="index" class="flex justify-between items-center p-2 bg-yellow-100 rounded-md">
        <div class="flex items-center space-x-4">
          <img :src="request.avatar" alt="avatar" class="w-8 h-8 rounded-full" />
          <span>{{ request.name }}</span>
        </div>
        <div class="space-x-2">
          <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Accept</button>
          <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Decline</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const requests = ref([
  { name: 'Jake Peralta', avatar: 'https://randomuser.me/api/portraits/men/18.jpg' },
  { name: 'Amy Santiago', avatar: 'https://randomuser.me/api/portraits/women/19.jpg' }
])
</script>
