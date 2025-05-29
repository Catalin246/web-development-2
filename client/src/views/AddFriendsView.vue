<template>
  <div class="p-4 py-6 md:p-16 md:py-10 w-full">
    <h2 class="text-2xl font-semibold mb-4">Add Friends</h2>
    <input
      v-model="searchQuery"
      @input="searchFriends"
      type="text"
      placeholder="Search for users..."
      class="w-full p-2 border border-gray-300 rounded-md mb-4"
    />

    <ul class="space-y-2">
      <li
        v-for="(result, index) in filteredResults"
        :key="result.id"
        class="flex justify-between items-center p-2 bg-gray-100 rounded-md"
      >
        <div class="flex items-center space-x-4">
          <img :src="result.avatar" alt="avatar" class="w-8 h-8 rounded-full" />
          <span>{{ result.name }}</span>
        </div>
        <button
          class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
          @click="sendRequest(result.id)"
        >
          Send Request
        </button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const urlValue = import.meta.env.VITE_API_URL
const searchQuery = ref('')
const results = ref([])

const fetchDiscoverableUsers = async () => {
  try {
    const response = await axios.get(`${urlValue}/friends/discover`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    results.value = response.data
  } catch (error) {
    console.error('Failed to fetch users:', error)
  }
}

const sendRequest = async (receiverId) => {
  try {
    await axios.post(
      `${urlValue}/friend-requests`,
      { receiver_id: receiverId },
      {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        },
      }
    )
    alert('Friend request sent!')
    await fetchDiscoverableUsers() // refresh the list
  } catch (error) {
    console.error('Failed to send request:', error)
    alert(error.response?.data?.error || 'Failed to send request')
  }
}

const searchFriends = () => {
  // this will update the filteredResults automatically
}

const filteredResults = computed(() =>
  results.value.filter((user) =>
    user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
)

onMounted(() => {
  fetchDiscoverableUsers()
})
</script>
