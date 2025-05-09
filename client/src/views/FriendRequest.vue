<script setup>
import { ref } from 'vue'

const searchQuery = ref('')
const results = ref([])

const searchFriends = () => {
  // Dummy logic for search
  results.value = ['John Doe', 'Jane Smith', 'Alex Brown'].filter(name =>
    name.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
}
</script>

<template>
  <div class="p-4 py-6 w-full">
    <h2 class="text-2xl font-semibold mb-4">Add Friends</h2>
    <input
      v-model="searchQuery"
      @input="searchFriends"
      type="text"
      placeholder="Search for users..."
      class="w-full p-2 border border-gray-300 rounded-md mb-4"
    />

    <ul class="space-y-2">
      <li v-for="(result, index) in results" :key="index" class="flex justify-between items-center p-2 bg-gray-100 rounded-md">
        <span>{{ result }}</span>
        <button class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Send Request</button>
      </li>
    </ul>
  </div>
</template>
