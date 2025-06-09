<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import axios from 'axios'
import ChatItem from '../components/ChatItem.vue'
import ChatWindow from '../components/ChatWindow.vue'

const selectedChat = ref(null)
const windowWidth = ref(window.innerWidth)
const currentUser = ref(null)
const chats = ref([])

const urlValue = import.meta.env.VITE_API_URL

function updateWidth() {
  windowWidth.value = window.innerWidth
}

function openChat(chat) {
  selectedChat.value = chat
}

async function fetchCurrentUser() {
  try {
    const token = localStorage.getItem('token')
    const res = await axios.get(`${urlValue}/auth/me`, {
      headers: { Authorization: `Bearer ${token}` }
    })
    currentUser.value = res.data
  } catch (err) {
    console.error('Failed to fetch current user:', err)
  }
}

async function fetchChats() {
  try {
    const token = localStorage.getItem('token')
    const res = await axios.get(`${urlValue}/chats`, {
      headers: { Authorization: `Bearer ${token}` }
    })

    chats.value = res.data.chats.map(chat => {
      const messages = chat.messages.map(msg => ({
        ...msg,
        timestamp: new Date(msg.timestamp),
        formattedTime: formatMessageTime(new Date(msg.timestamp))
      }))
      const unread = messages.filter(m => !m.read).length

      let displayName = chat.name
      let displayAvatar = chat.avatar

      if (chat.type === 'normal') {
        const other = chat.participants.find(p => p.id !== currentUser.value.id)
        displayName = other?.name || 'Chat'
        displayAvatar = other?.avatar || null
      }

      return {
        ...chat,
        name: displayName,
        avatar: displayAvatar,
        unread,
        messages
      }
    })
  } catch (err) {
    console.error('Failed to fetch chats:', err)
  }
}

function formatMessageTime(timestamp) {
  const now = new Date()
  const diff = now - timestamp
  const oneDay = 24 * 60 * 60 * 1000

  if (diff < oneDay) {
    return timestamp.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
  } else if (diff < 2 * oneDay) {
    return 'Yesterday'
  } else {
    return timestamp.toLocaleDateString()
  }
}

const calculatedChats = computed(() => {
  return chats.value.map(chat => ({
    ...chat,
    messages: chat.messages.map(msg => ({
      ...msg,
      formattedTime: formatMessageTime(msg.timestamp)
    }))
  }))
})

onMounted(async () => {
  window.addEventListener('resize', updateWidth)
  await fetchCurrentUser()
  if (currentUser.value) await fetchChats()
})

onUnmounted(() => {
  window.removeEventListener('resize', updateWidth)
})
</script>

<template>
  <!-- Chat List -->
  <div
    v-if="!selectedChat || windowWidth >= 768"
    class="w-full md:w-[30%] overflow-y-auto hide-scrollbar shadow-right"
  >
    <div v-for="chat in calculatedChats" :key="chat.name" @click="openChat(chat)">
      <ChatItem
        :name="chat.name"
        :avatar="chat.avatar"
        :unread="chat.unread"
        :lastMessage="chat.messages.length ? chat.messages[chat.messages.length - 1] : null"
        :time="chat.messages.length ? chat.messages[chat.messages.length - 1].formattedTime : ''"
      />
    </div>
  </div>

  <!-- Chat Window -->
  <div
    v-if="selectedChat"
    class="w-full md:w-[70%] p-4 overflow-y-auto hide-scrollbar pt-8"
  >
    <div class="md:hidden mb-4">
      <button @click="selectedChat = null" class="text-blue-600">&larr; Back</button>
    </div>
    <ChatWindow :chat="selectedChat" />
  </div>

  <!-- Placeholder when no chat is selected (desktop only) -->
  <div
    v-else
    class="hidden md:flex w-[70%] items-center justify-center text-gray-500 text-md"
  >
    Select a chat to start messaging
  </div>
</template>
