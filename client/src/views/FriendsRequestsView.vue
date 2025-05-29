<template>
  <div class="p-4 py-6 md:p-16 md:py-10 w-full">
    <h2 class="text-2xl font-semibold mb-4">Friend Requests</h2>
    <ul class="space-y-2">
      <li
        v-for="request in requests"
        :key="request.id"
        class="flex justify-between items-center p-2 bg-yellow-100 rounded-md"
      >
        <div class="flex items-center space-x-4">
          <img :src="request.sender_avatar" alt="avatar" class="w-8 h-8 rounded-full" />
          <span>{{ request.sender_name }}</span>
        </div>
        <div class="space-x-2">
          <button
            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
            @click="respondToRequest(request.id, 'accepted')"
          >
            Accept
          </button>
          <button
            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
            @click="respondToRequest(request.id, 'declined')"
          >
            Decline
          </button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const requests = ref([])
const urlValue = import.meta.env.VITE_API_URL || 'http://localhost:8000'

const fetchFriendRequests = async () => {
  try {
    const response = await axios.get(`${urlValue}/friend-requests`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    requests.value = response.data.requests
  } catch (error) {
    console.error('Failed to fetch friend requests:', error)
  }
}

const respondToRequest = async (requestId, status) => {
  try {
    await axios.put(
      `${urlValue}/friend-requests/${requestId}`,
      { status },
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        },
      }
    )
    // Remove the request from the list after update
    requests.value = requests.value.filter((r) => r.id !== requestId)
  } catch (error) {
    console.error(`Failed to ${status} request:`, error)
    alert(error.response?.data?.error || 'Something went wrong')
  }
}

onMounted(() => {
  fetchFriendRequests()
})
</script>
