<!-- src/views/FriendsListView.vue -->
<template>
  <div class="p-4 py-6 md:p-16 md:py-10 w-full">
    <h2 class="text-2xl font-semibold mb-4">Your Friends</h2>
    <ul class="space-y-2">
      <li v-for="(friend, index) in friends" :key="index" class="flex justify-between items-center p-2 bg-green-100 rounded-md">
        <div class="flex items-center space-x-4">
          <img :src="friend.avatar" alt="avatar" class="w-8 h-8 rounded-full" />
          <span>{{ friend.name }}</span>
        </div>
        <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Chat</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const friends = ref([
  { name: 'Terry Jeffords', avatar: 'https://randomuser.me/api/portraits/men/20.jpg' },
  { name: 'Rosa Diaz', avatar: 'https://randomuser.me/api/portraits/women/21.jpg' }
])
</script>
