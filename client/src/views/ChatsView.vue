<script setup>
import { ref } from 'vue'
import ChatItem from '../components/ChatItem.vue'
import ChatWindow from '../components/ChatWindow.vue'

const selectedChat = ref(null)

const chats = [
  {
    name: "Sarah Johnson",
    message: "Hey, are we still meeting tomorrow at the coffee shop?",
    time: "09:15",
    unread: 2,
    avatar: "https://randomuser.me/api/portraits/women/1.jpg"
  },
  {
    name: "Tech Support",
    message: "Your ticket #4567 has been resolved. Please confirm if everything works now.",
    time: "Yesterday",
    unread: 1,
    avatar: "https://randomuser.me/api/portraits/men/1.jpg"
  },
  {
    name: "Mom",
    message: "Don't forget about family dinner this Sunday! 🍗",
    time: "Yesterday",
    unread: 0,
    avatar: "https://randomuser.me/api/portraits/women/2.jpg"
  },
  {
    name: "Alex Taylor",
    message: "Just sent you the project files. Let me know what you think!",
    time: "11/05",
    unread: 3,
    avatar: "https://randomuser.me/api/portraits/men/2.jpg"
  },
  {
    name: "Work Group",
    message: "Meeting moved to 3pm | Jenny: I'll be late | Mike: Got it",
    time: "10/05",
    unread: 12,
    avatar: "https://randomuser.me/api/portraits/men/3.jpg"
  },
  {
    name: "James Wilson",
    message: "The design mockups look great! Just a few small changes needed...",
    time: "08/05",
    unread: 0,
    avatar: "https://randomuser.me/api/portraits/men/4.jpg"
  },
  {
    name: "Emma Davis",
    message: "Thanks for the birthday wishes! 🎉",
    time: "05/05",
    unread: 0,
    avatar: "https://randomuser.me/api/portraits/women/3.jpg"
  },
  {
    name: "Delivery",
    message: "Your package #12345 has been delivered",
    time: "03/05",
    unread: 0,
    avatar: "https://randomuser.me/api/portraits/men/5.jpg"
  },
  {
    name: "David Miller",
    message: "Let me know when you're free for a call about the new project",
    time: "01/05",
    unread: 1,
    avatar: "https://randomuser.me/api/portraits/men/6.jpg"
  },
  {
    name: "Study Group",
    message: "Final exam on Friday | Maria: I'll bring snacks | Tom: Can someone share notes?",
    time: "28/04",
    unread: 7,
    avatar: "https://randomuser.me/api/portraits/women/4.jpg"
  },
  {
    name: "Olivia Brown",
    message: "The restaurant was amazing! We should go there again soon 😊",
    time: "25/04",
    unread: 0,
    avatar: "https://randomuser.me/api/portraits/women/5.jpg"
  },
  {
    name: "Bank Alerts",
    message: "Reminder: Credit card payment due in 3 days",
    time: "20/04",
    unread: 0,
    avatar: "https://randomuser.me/api/portraits/men/7.jpg"
  }
];

function openChat(chat) {
  selectedChat.value = chat
}
</script>

<template>
  <div class="flex w-full h-full overflow-hidden">
    <!-- Chat List (Mobile: full width, Desktop: 20%) -->
    <div v-if="!selectedChat || window.innerWidth >= 768" class="w-full md:w-[25%] overflow-y-auto border-r">
      <div v-for="chat in chats" :key="chat.name" @click="openChat(chat)">
        <ChatItem v-bind="chat" />
      </div>
    </div>

    <!-- Chat Window (Mobile: overlay, Desktop: 70%) -->
    <div v-if="selectedChat" class="w-full md:w-[75%] p-4 overflow-y-auto">
      <div class="md:hidden mb-4">
        <button @click="selectedChat = null" class="text-blue-600">&larr; Back</button>
      </div>
      <ChatWindow :chat="selectedChat" />
    </div>
  </div>
</template>
