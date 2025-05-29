<template>
  <div class="py-4 md:p-8 w-full">
    <div class="max-w-xl mx-auto bg-white rounded-xl p-4 space-y-4">
      <div class="flex items-center space-x-4">
        <img
          :src="user.avatar"
          class="w-16 h-16 rounded-full"
          alt="User Avatar"
        />
        <div>
          <h2 class="text-xl font-semibold">{{ user.name }}</h2>
          <p class="text-gray-500">{{ user.email }}</p>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
        <input
          v-model="user.status"
          type="text"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
          placeholder="Busy, at work, etc."
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">About</label>
        <textarea
          v-model="user.about"
          rows="3"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
          placeholder="Say something about yourself"
        ></textarea>
      </div>

      <button
        @click="updateProfile"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition"
      >
        Save
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const apiUrl = import.meta.env.VITE_API_URL

const user = ref({
  name: '',
  email: '',
  avatar: '',
  status: '',
  about: ''
})

const defaultAvatar = 'https://randomuser.me/api/portraits/lego/4.jpg'

onMounted(async () => {
  try {
    const response = await axios.get(`${apiUrl}/auth/me`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
      }
    })
    user.value = response.data
  } catch (error) {
    console.error('Failed to fetch user info:', error)
  }
})

const updateProfile = async () => {
  try {
    const token = localStorage.getItem('token')

    const response = await axios.put(
      `${apiUrl}/auth/update-profile`,
      {
        status: user.value.status,
        about: user.value.about
      },
      {
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      }
    )

    alert('Profile updated successfully!')
  } catch (error) {
    console.error('Profile update failed:', error)
    alert('Failed to update profile')
  }
}
</script>
