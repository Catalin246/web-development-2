<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import ChatItem from '../components/ChatItem.vue'
import ChatWindow from '../components/ChatWindow.vue'

const selectedChat = ref(null)
const windowWidth = ref(window.innerWidth)

function openChat(chat) {
  selectedChat.value = chat
}

function updateWidth() {
  windowWidth.value = window.innerWidth
}

onMounted(() => {
  window.addEventListener('resize', updateWidth)
})
onUnmounted(() => {
  window.removeEventListener('resize', updateWidth)
})

// Chats data with a computed unread count
const chats = ref([
  {
    name: "Sarah Johnson",
    time: "09:15",
    avatar: "https://randomuser.me/api/portraits/women/1.jpg",
    messages: [
      { text: "Hey, are we still meeting tomorrow at the coffee shop?", read: false, fromMe: false },
      { text: "I’ll be there at 10!", read: false, fromMe: true },
      { text: "Don’t forget the book 📖", read: true, fromMe: false }
    ]
  },
  {
    name: "Tech Support",
    time: "Yesterday",
    avatar: "https://randomuser.me/api/portraits/men/1.jpg",
    messages: [
      { text: "We’ve received your ticket.", read: true, fromMe: false },
      { text: "Issue identified, working on it now.", read: true, fromMe: false },
      { text: "Your ticket #4567 has been resolved. Please confirm if everything works now.", read: false, fromMe: false }
    ]
  },
  {
    name: "Mom",
    time: "Yesterday",
    avatar: "https://randomuser.me/api/portraits/women/2.jpg",
    messages: [
      { text: "Don't forget about family dinner this Sunday! 🍗", read: true, fromMe: false },
      { text: "Bringing your favorite pie!", read: true, fromMe: false },
      { text: "Call me later ❤️", read: true, fromMe: false }
    ]
  },
  {
    name: "Alex Taylor",
    time: "11/05",
    avatar: "https://randomuser.me/api/portraits/men/2.jpg",
    messages: [
      { text: "Just sent you the project files.", read: false, fromMe: false },
      { text: "Let me know what you think!", read: false, fromMe: false },
      { text: "Also check the updated timeline.", read: false, fromMe: false }
    ]
  },
  {
    name: "Work Group",
    time: "10/05",
    avatar: "https://randomuser.me/api/portraits/men/3.jpg",
    messages: [
      { text: "Meeting moved to 3pm", read: false, fromMe: false },
      { text: "Jenny: I'll be late", read: false, fromMe: false },
      { text: "Mike: Got it", read: false, fromMe: false },
      { text: "I'll update the notes later.", read: true, fromMe: true }
    ]
  },
  {
    name: "James Wilson",
    time: "08/05",
    avatar: "https://randomuser.me/api/portraits/men/4.jpg",
    messages: [
      { text: "The design mockups look great!", read: true, fromMe: false },
      { text: "Just a few small changes needed...", read: true, fromMe: false },
      { text: "Will send notes shortly.", read: true, fromMe: false }
    ]
  },
  {
    name: "Emma Davis",
    time: "05/05",
    avatar: "https://randomuser.me/api/portraits/women/3.jpg",
    messages: [
      { text: "Thanks for the birthday wishes! 🎉", read: true, fromMe: false },
      { text: "It was such a fun day!", read: true, fromMe: false },
      { text: "Let's catch up soon.", read: true, fromMe: false }
    ]
  },
  {
    name: "Delivery",
    time: "03/05",
    avatar: "https://randomuser.me/api/portraits/men/5.jpg",
    messages: [
      { text: "Your package #12345 has been shipped.", read: true, fromMe: false },
      { text: "Out for delivery now.", read: true, fromMe: false },
      { text: "Your package #12345 has been delivered", read: true, fromMe: false }
    ]
  },
  {
    name: "David Miller",
    time: "01/05",
    avatar: "https://randomuser.me/api/portraits/men/6.jpg",
    messages: [
      { text: "Let me know when you're free.", read: true, fromMe: false },
      { text: "Want to talk about the new project.", read: true, fromMe: false },
      { text: "Ping me anytime today.", read: false, fromMe: false }
    ]
  },
  {
    name: "Study Group",
    time: "28/04",
    avatar: "https://randomuser.me/api/portraits/women/4.jpg",
    messages: [
      { text: "Final exam on Friday", read: false, fromMe: false },
      { text: "Maria: I'll bring snacks", read: false, fromMe: false },
      { text: "Tom: Can someone share notes?", read: false, fromMe: false },
      { text: "Sure, I'll upload mine tonight.", read: true, fromMe: true }
    ]
  },
  {
    name: "Olivia Brown",
    time: "25/04",
    avatar: "https://randomuser.me/api/portraits/women/5.jpg",
    messages: [
      { text: "The restaurant was amazing!", read: true, fromMe: false },
      { text: "We should go there again soon 😊", read: true, fromMe: false },
      { text: "Next weekend?", read: true, fromMe: false }
    ]
  },
  {
    name: "Bank Alerts",
    time: "20/04",
    avatar: "https://randomuser.me/api/portraits/men/7.jpg",
    messages: [
      { text: "Reminder: Credit card payment due in 3 days", read: true, fromMe: false },
      { text: "Auto payment enabled", read: true, fromMe: false },
      { text: "Thank you for your payment", read: true, fromMe: false }
    ]
  }
])

// Computed property to calculate unread messages count for each chat
const calculatedChats = computed(() => {
  return chats.value.map(chat => {
    const unreadCount = chat.messages.filter(message => !message.read).length
    return {
      ...chat,
      unread: unreadCount
    }
  })
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
        :time="chat.time"
        :unread="chat.unread"
        :lastMessage="chat.messages.length ? chat.messages[chat.messages.length - 1] : null"
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
</template>
