<template>
  <div class="w-full mx-auto my-10 p-6 md:px-12 lg:px-32 bg-white rounded-xl space-y-6">
    <h2 class="text-xl font-semibold text-gray-800">Create a Group Chat</h2>

    <div class="space-y-4">
      <!-- Group Name -->
      <div>
        <label class="block text-gray-700 mb-1">Group Name</label>
        <input
          v-model="groupName"
          type="text"
          placeholder="e.g. Study Buddies"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <!-- Avatar URL -->
      <div>
        <label class="block text-gray-700 mb-1">Avatar URL (optional)</label>
        <input
          v-model="avatarUrl"
          type="text"
          placeholder="Paste an image URL"
          class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
      </div>

      <!-- Avatar Preview -->
      <div v-if="previewAvatar" class="flex items-center gap-2">
        <span class="text-gray-600 text-sm">Preview:</span>
        <img :src="previewAvatar" alt="Avatar Preview" class="w-12 h-12 rounded-full border" />
      </div>

      <!-- Friend Selector -->
      <div>
        <label class="block text-gray-700 mb-1">Add Friends</label>
        <div class="flex flex-col gap-2 max-h-40 overflow-y-auto">
          <label v-for="friend in friends" :key="friend.id" class="flex items-center gap-2">
            <input
              type="checkbox"
              :value="friend.id"
              v-model="selectedFriendIds"
              class="accent-blue-600"
            />
            <span class="text-sm text-gray-800">{{ friend.name }}</span>
          </label>
        </div>
      </div>

      <!-- Submit Button -->
      <div>
        <button
          @click="handleCreateGroup"
          :disabled="!groupName || selectedFriendIds.length === 0"
          class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg disabled:opacity-50"
        >
          Create Group
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const groupName = ref('')
const avatarUrl = ref('')
const selectedFriendIds = ref([])

const defaultGroupAvatar = 'https://cdn-icons-png.flaticon.com/512/921/921347.png'
const previewAvatar = computed(() => avatarUrl.value || defaultGroupAvatar)

const friends = ref([])

const router = useRouter()

async function fetchFriends() {
  const token = localStorage.getItem('token')
  try {
    const res = await axios.get(`${import.meta.env.VITE_API_URL}/friends/list`, {
      headers: { Authorization: `Bearer ${token}` }
    })
    friends.value = res.data
  } catch (err) {
    console.error('Failed to fetch friends. Using dummy list.')
  }
}

async function handleCreateGroup() {
  if (selectedFriendIds.value.length < 3) {
    alert('Please add at least 3 members to the group.')
    return
  }

  const token = localStorage.getItem('token')

  const payload = {
    name: groupName.value,
    avatar: avatarUrl.value || defaultGroupAvatar,
    participant_ids: selectedFriendIds.value
  }

  try {
    const res = await axios.post(`${import.meta.env.VITE_API_URL}/chats`, payload, {
      headers: { Authorization: `Bearer ${token}` }
    })

    const newChatId = res.data.chat.id

    groupName.value = ''
    avatarUrl.value = ''
    selectedFriendIds.value = []

    router.push(`/groups/${newChatId}`)
  } catch (err) {
    console.error('Failed to create group chat:', err)
    alert('Something went wrong.')
  }
}

onMounted(() => {
  fetchFriends()
})
</script>
