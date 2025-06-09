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
        <button
          class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
          @click="startChatWith(friend)"
        >
          Chat
        </button>
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
const currentUser = ref(null)
const urlValue = import.meta.env.VITE_API_URL

const fetchFriends = async () => {
  try {
    const response = await axios.get(`${urlValue}/friends/list`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    friends.value = response.data
  } catch (error) {
    console.error('Failed to fetch friends:', error)
  }
}

const fetchCurrentUser = async () => {
  try {
    const response = await axios.get(`${urlValue}/auth/me`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    currentUser.value = response.data
  } catch (error) {
    console.error('Failed to fetch current user:', error)
  }
}

const startChatWith = async (friend) => {
  if (!currentUser.value) return

  const payload = {
    participant_ids: [currentUser.value.id, friend.id],
    name: `Chat with ${friend.name}`,
  }

  try {
    const response = await axios.post(`${urlValue}/chats`, payload, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    console.log('Chat created:', response.data)
    // TO DO: Redirect to chat view here 
  } catch (error) {
    console.error('Failed to create chat:', error.response?.data || error.message)
  }
}

onMounted(() => {
  fetchCurrentUser()
  fetchFriends()
})
</script>
