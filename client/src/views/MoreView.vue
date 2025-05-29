<template>
  <div class="py-4 md:p-8 w-full">
    <div class="max-w-xl mx-auto bg-white rounded-xl p-4 space-y-4">
      <h2 class="text-2xl font-semibold">Settings</h2>

      <div v-if="loaded" class="space-y-4">
        <div class="flex justify-between items-center">
          <span class="text-gray-700">Notifications</span>
          <input
            type="checkbox"
            class="form-checkbox h-5 w-5 text-blue-600"
            v-model="settings.notifications"
            @change="updateSetting('notifications', settings.notifications)"
          />
        </div>
        <div class="flex justify-between items-center">
          <span class="text-gray-700">Dark Mode</span>
          <input
            type="checkbox"
            class="form-checkbox h-5 w-5 text-blue-600"
            v-model="settings.dark_mode"
            @change="updateSetting('dark_mode', settings.dark_mode)"
          />
        </div>
        <div class="flex justify-between items-center">
          <span class="text-gray-700">Privacy Mode</span>
          <input
            type="checkbox"
            class="form-checkbox h-5 w-5 text-blue-600"
            v-model="settings.privacy_mode"
            @change="updateSetting('privacy_mode', settings.privacy_mode)"
          />
        </div>
      </div>

      <button
        @click="logout"
        class="mt-6 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition"
      >
        Log Out
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const apiUrl = import.meta.env.VITE_API_URL
const router = useRouter()

const settings = ref({
  notifications: false,
  dark_mode: false,
  privacy_mode: false,
})

const loaded = ref(false)

const token = localStorage.getItem('token')

async function fetchSettings() {
  try {
    const res = await fetch(`${apiUrl}/settings`, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })
    if (!res.ok) throw new Error('Failed to fetch settings')
    const data = await res.json()
    settings.value = {
      notifications: Boolean(data.notifications),
      dark_mode: Boolean(data.dark_mode),
      privacy_mode: Boolean(data.privacy_mode)
    }
    loaded.value = true
  } catch (err) {
    console.error(err)
  }
}

async function updateSetting(key, value) {
  try {
    await fetch(`${apiUrl}/settings`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`
      },
      body: JSON.stringify({ [key]: value ? 1 : 0 }) // backend expects 0/1
    })
  } catch (err) {
    console.error('Failed to update setting:', err)
  }
}

function logout() {
  localStorage.removeItem('token')
  router.push('/login')
}

onMounted(() => {
  if (!token) {
    router.push('/login')
    return
  }
  fetchSettings()
})
</script>
