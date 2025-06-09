<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
import ChatItem from '../components/ChatItem.vue'
import ChatWindow from '../components/ChatWindow.vue'

const route = useRoute()
const router = useRouter()

const selectedChat = ref(null)
const windowWidth = ref(window.innerWidth)
const currentUser = ref(null)
const chats = ref([])

const urlValue = import.meta.env.VITE_API_URL

function updateWidth() {
  windowWidth.value = window.innerWidth
}

async function openChat(chat) {
  selectedChat.value = chat
  router.replace({ params: { chatId: chat.id } })

  const token = localStorage.getItem('token')

  try {
    await axios.put(`${urlValue}/chats/${chat.id}/mark-read`, {}, {
      headers: {
        Authorization: `Bearer ${token}`
      }
    })

    // Optional: Refresh chats list after marking read
    await fetchChats()
  } catch (err) {
    console.error('Failed to mark messages as read:', err)
  }
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

    chats.value = res.data.chats
      .filter(chat => chat.type === 'normal')
      .map(chat => {
        const messages = chat.messages.map(msg => ({
          ...msg,
          timestamp: new Date(msg.timestamp),
          formattedTime: formatMessageTime(new Date(msg.timestamp))
        }))
        const unread = messages.filter(m => !m.read && m.from !== currentUser.value.id).length

        let displayName = chat.name
        let displayAvatar = chat.avatar

        const other = chat.participants.find(p => p.id !== currentUser.value.id)
        displayName = other?.name || 'Chat'
        displayAvatar = other?.avatar || null

        return {
          ...chat,
          name: displayName,
          avatar: displayAvatar,
          unread,
          messages
        }
      })

    const chatIdFromUrl = route.params.chatId
    if (chatIdFromUrl) {
      const chatToOpen = chats.value.find(c => String(c.id) === String(chatIdFromUrl))
      if (chatToOpen) {
        selectedChat.value = chatToOpen
      }
    }
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

// Watch for URL chatId param changes
watch(() => route.params.chatId, (newChatId) => {
  if (newChatId) {
    const chatToOpen = chats.value.find(c => String(c.id) === String(newChatId))
    if (chatToOpen) {
      selectedChat.value = chatToOpen
    } else {
      selectedChat.value = null
    }
  } else {
    selectedChat.value = null
  }
})

// Handler to refresh a single chat's messages after send
async function handleRefreshChat() {
  fetchChats()

  // Reassign the selectedChat using the chatId in the route
  const chatIdFromUrl = route.params.chatId
  if (chatIdFromUrl) {
    const updatedChat = chats.value.find(c => String(c.id) === String(chatIdFromUrl))
    if (updatedChat) {
      selectedChat.value = updatedChat
    }
  }
}

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
    <div v-for="chat in calculatedChats" :key="chat.id" @click="openChat(chat)">
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
    <ChatWindow :chat="selectedChat" @refresh-chat="handleRefreshChat" />
  </div>

  <!-- Placeholder when no chat is selected (desktop only) -->
  <div
    v-else
    class="hidden md:flex w-[70%] items-center justify-center text-gray-500 text-md"
  >
    Select a chat to start messaging
  </div>
</template>
