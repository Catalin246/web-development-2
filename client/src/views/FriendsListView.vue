<template>
  <div class="p-4 py-6 md:p-16 md:py-10 w-full">
    <h2 class="text-2xl font-semibold mb-4">Your Friends</h2>

    <ul v-if="friends.length > 0" class="space-y-2">
      <li
        v-for="friend in friends"
        :key="friend.id"
        class="flex justify-between items-center p-2 bg-green-100 rounded-md"
      >
        <div class="flex items-center space-x-4">
          <img :src="friend.avatar" alt="avatar" class="w-8 h-8 rounded-full" />
          <span>{{ friend.name }}</span>
        </div>
        <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
          Chat
        </button>
        <!-- TODO: Implement chat feature when ready -->
      </li>
    </ul>

    <p v-else class="text-gray-500 italic mt-4">
      You have no friends yet. Try adding some!
    </p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const friends = ref([])
const urlValue = import.meta.env.VITE_API_URL

const fetchFriends = async () => {
  try {
    const response = await axios.get(`${urlValue}/friends/list`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    friends.value = response.data // Assign the array directly
  } catch (error) {
    console.error('Failed to fetch friends:', error)
  }
}

onMounted(() => {
  fetchFriends()
})
</script>
