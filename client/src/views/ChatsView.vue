<script setup>
import { ref, onMounted, onUnmounted, computed } from 'vue'
import ChatItem from '../components/ChatItem.vue'
import ChatWindow from '../components/ChatWindow.vue'

// Store for the selected chat and window width
const selectedChat = ref(null)
const windowWidth = ref(window.innerWidth)
const userName = "John Doe";  // Your name to replace "You" in chats

// Function to open a selected chat
function openChat(chat) {
  selectedChat.value = chat
}

// Function to update the window width
function updateWidth() {
  windowWidth.value = window.innerWidth
}

// Set up event listeners for window resizing
onMounted(() => {
  window.addEventListener('resize', updateWidth)
})
onUnmounted(() => {
  window.removeEventListener('resize', updateWidth)
})

// Chats data with owner information in messages and handling group chats
const chats = ref([
  // Example for normal chat with 2 people
  {
    type: 'normal',
    name: "Sarah Johnson",
    avatar: "https://randomuser.me/api/portraits/women/1.jpg",
    participants: [
      { id: 1, name: userName, avatar: 'https://randomuser.me/api/portraits/men/8.jpg' },
      { id: 2, name: 'Sarah Johnson', avatar: 'https://randomuser.me/api/portraits/women/1.jpg' }
    ],
    messages: [
      { text: "Hey, are we still meeting tomorrow at the coffee shop?", timestamp: new Date('2025-05-06T09:15:00'), read: true, from: 2 },
      { text: "I’ll be there at 10!", timestamp: new Date('2025-05-06T09:20:00'), read: false, from: 1 },
      { text: "Don’t forget the book 📖", timestamp: new Date('2025-05-05T18:00:00'), read: true, from: 2 }
    ]
  },
  
  // Example for a group chat with multiple participants
  {
    type: 'group',
    name: "Work Group",
    avatar: "https://randomuser.me/api/portraits/men/3.jpg",
    participants: [
      { id: 1, name: userName, avatar: 'https://randomuser.me/api/portraits/men/8.jpg' },
      { id: 2, name: 'Jenny', avatar: 'https://randomuser.me/api/portraits/women/2.jpg' },
      { id: 3, name: 'Mike', avatar: 'https://randomuser.me/api/portraits/men/2.jpg' },
      { id: 4, name: 'Charlie', avatar: 'https://randomuser.me/api/portraits/men/4.jpg' }
    ],
    messages: [
      { text: "Meeting moved to 3pm", timestamp: new Date('2025-05-06T10:30:00'), read: false, from: 2 },
      { text: "Jenny: I'll be late", timestamp: new Date('2025-05-06T10:35:00'), read: false, from: 3 },
      { text: "Mike: Got it", timestamp: new Date('2025-05-06T10:40:00'), read: false, from: 4 },
      { text: "I'll update the notes later.", timestamp: new Date('2025-05-06T10:50:00'), read: true, from: 1 }
    ]
  }
])

// Function to format message time
function formatMessageTime(timestamp) {
  const now = new Date();
  const diffInMs = now - timestamp;
  const oneDay = 24 * 60 * 60 * 1000;

  if (diffInMs < oneDay) {
    return timestamp.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  } else if (diffInMs < 2 * oneDay) {
    return 'Yesterday';
  } else {
    return timestamp.toLocaleDateString();
  }
}

// Computed property for unread messages count and formatted time
const calculatedChats = computed(() => {
  return chats.value.map(chat => {
    const unreadCount = chat.messages.filter(message => !message.read).length;
    return {
      ...chat,
      unread: unreadCount,
      messages: chat.messages.map(message => ({
        ...message,
        formattedTime: formatMessageTime(message.timestamp)
      }))
    };
  });
});

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
</template>
