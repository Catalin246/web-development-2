<script setup>
import { ref } from 'vue'
import ChatItem from '../components/ChatItem.vue'
import ChatWindow from '../components/ChatWindow.vue'

const selectedChat = ref(null)

const allChats = [
  {
    name: "Work Group",
    message: "Meeting moved to 3pm | Jenny: I'll be late | Mike: Got it",
    time: "10/05",
    unread: 12,
    avatar: "https://randomuser.me/api/portraits/men/3.jpg",
    isGroup: true
  },
  {
    name: "Study Group",
    message: "Final exam on Friday | Maria: I'll bring snacks | Tom: Can someone share notes?",
    time: "28/04",
    unread: 7,
    avatar: "https://randomuser.me/api/portraits/women/4.jpg",
    isGroup: true
  }
];

const groups = allChats.filter(chat => chat.isGroup)

function openChat(chat) {
  selectedChat.value = chat
}
</script>

<template>
  <div class="flex w-full h-full overflow-hidden">
    <!-- Chat List -->
    <div v-if="!selectedChat || window.innerWidth >= 768" class="w-full md:w-[20%] overflow-y-auto border-r">
      <div v-for="chat in groups" :key="chat.name" @click="openChat(chat)">
        <ChatItem v-bind="chat" />
      </div>
    </div>

    <!-- Chat Window -->
    <div v-if="selectedChat" class="w-full md:w-[70%] p-4 overflow-y-auto">
      <div class="md:hidden mb-4">
        <button @click="selectedChat = null" class="text-blue-600">&larr; Back</button>
      </div>
      <ChatWindow :chat="selectedChat" />
    </div>
  </div>
</template>
