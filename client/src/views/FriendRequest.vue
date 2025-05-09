<script setup>
import { ref, onMounted } from 'vue'

const searchQuery = ref('')
const results = ref([])

// Dummy user data for search results (you can replace this with dynamic data or API)
const users = [
  { name: 'John Doe', avatar: 'https://randomuser.me/api/portraits/men/13.jpg' },
  { name: 'Jane Smith', avatar: 'https://randomuser.me/api/portraits/men/14.jpg' },
  { name: 'Alex Brown', avatar: 'https://randomuser.me/api/portraits/men/15.jpg' },
  { name: 'Alex Mertz', avatar: 'https://randomuser.me/api/portraits/men/16.jpg' },
  { name: 'Mihail Smooth', avatar: 'https://randomuser.me/api/portraits/men/17.jpg' },
]

// Dummy search function
const searchFriends = () => {
  results.value = users.filter(user =>
    user.name.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
}

// Load the data as soon as the page starts
onMounted(() => {
  results.value = users // Load all users when the component is mounted
})
</script>

<template>
  <div class="p-4 py-6 md:p-16 md:py-10 w-full">
    <!-- Search Friends Section -->
    <h2 class="text-2xl font-semibold mb-4">Add Friends</h2>
    <input
      v-model="searchQuery"
      @input="searchFriends"
      type="text"
      placeholder="Search for users..."
      class="w-full p-2 border border-gray-300 rounded-md mb-4"
    />

    <!-- Search Results -->
    <ul class="space-y-2">
      <li v-for="(result, index) in results" :key="index" class="flex justify-between items-center p-2 bg-gray-100 rounded-md">
        <!-- Display Avatar for each result -->
        <div class="flex items-center space-x-4">
          <img :src="result.avatar" alt="avatar" class="w-8 h-8 rounded-full" />
          <span>{{ result.name }}</span>
        </div>
        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Send Request</button>
      </li>
    </ul>
  </div>
</template>
