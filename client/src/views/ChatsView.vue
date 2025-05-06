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

// Chats data with individual timestamps for each message
const chats = ref([
  {
    name: "Sarah Johnson",
    avatar: "https://randomuser.me/api/portraits/women/1.jpg",
    messages: [
      { text: "Hey, are we still meeting tomorrow at the coffee shop?", timestamp: new Date('2025-05-06T09:15:00'), read: true, fromMe: false },
      { text: "I’ll be there at 10!", timestamp: new Date('2025-05-06T09:20:00'), read: false, fromMe: true },
      { text: "Don’t forget the book 📖", timestamp: new Date('2025-05-05T18:00:00'), read: true, fromMe: false }
    ]
  },
  {
    name: "Tech Support",
    avatar: "https://randomuser.me/api/portraits/men/1.jpg",
    messages: [
      { text: "We’ve received your ticket.", timestamp: new Date('2025-05-05T10:00:00'), read: true, fromMe: false },
      { text: "Issue identified, working on it now.", timestamp: new Date('2025-05-05T12:30:00'), read: true, fromMe: false },
      { text: "Your ticket #4567 has been resolved. Please confirm if everything works now.", timestamp: new Date('2025-05-05T15:45:00'), read: false, fromMe: false }
    ]
  },
  {
    name: "Mom",
    avatar: "https://randomuser.me/api/portraits/women/2.jpg",
    messages: [
      { text: "Don't forget about family dinner this Sunday! 🍗", timestamp: new Date('2025-05-04T14:30:00'), read: true, fromMe: false },
      { text: "Bringing your favorite pie!", timestamp: new Date('2025-05-04T15:00:00'), read: true, fromMe: false },
      { text: "Call me later ❤️", timestamp: new Date('2025-05-04T18:00:00'), read: true, fromMe: false }
    ]
  },
  {
    name: "Alex Taylor",
    avatar: "https://randomuser.me/api/portraits/men/2.jpg",
    messages: [
      { text: "Just sent you the project files.", timestamp: new Date('2025-05-06T09:00:00'), read: false, fromMe: false },
      { text: "Let me know what you think!", timestamp: new Date('2025-05-06T09:05:00'), read: false, fromMe: false },
      { text: "Also check the updated timeline.", timestamp: new Date('2025-05-06T09:10:00'), read: false, fromMe: false }
    ]
  },
  {
    name: "Work Group",
    avatar: "https://randomuser.me/api/portraits/men/3.jpg",
    messages: [
      { text: "Meeting moved to 3pm", timestamp: new Date('2025-05-06T10:30:00'), read: false, fromMe: false },
      { text: "Jenny: I'll be late", timestamp: new Date('2025-05-06T10:35:00'), read: false, fromMe: false },
      { text: "Mike: Got it", timestamp: new Date('2025-05-06T10:40:00'), read: false, fromMe: false },
      { text: "I'll update the notes later.", timestamp: new Date('2025-05-06T10:50:00'), read: true, fromMe: true }
    ]
  },
  {
    name: "James Wilson",
    avatar: "https://randomuser.me/api/portraits/men/4.jpg",
    messages: [
      { text: "The design mockups look great!", timestamp: new Date('2025-05-03T09:15:00'), read: true, fromMe: false },
      { text: "Just a few small changes needed...", timestamp: new Date('2025-05-03T09:20:00'), read: true, fromMe: false },
      { text: "Will send notes shortly.", timestamp: new Date('2025-05-03T09:30:00'), read: true, fromMe: false }
    ]
  },
  {
    name: "Emma Davis",
    avatar: "https://randomuser.me/api/portraits/women/3.jpg",
    messages: [
      { text: "Thanks for the birthday wishes! 🎉", timestamp: new Date('2025-05-01T15:00:00'), read: true, fromMe: false },
      { text: "It was such a fun day!", timestamp: new Date('2025-05-01T15:10:00'), read: true, fromMe: false },
      { text: "Let's catch up soon.", timestamp: new Date('2025-05-01T15:20:00'), read: true, fromMe: false }
    ]
  },
  {
    name: "Delivery",
    avatar: "https://randomuser.me/api/portraits/men/5.jpg",
    messages: [
      { text: "Your package #12345 has been shipped.", timestamp: new Date('2025-04-30T10:00:00'), read: true, fromMe: false },
      { text: "Out for delivery now.", timestamp: new Date('2025-04-30T11:00:00'), read: true, fromMe: false },
      { text: "Your package #12345 has been delivered", timestamp: new Date('2025-04-30T12:00:00'), read: true, fromMe: false }
    ]
  },
  {
    name: "David Miller",
    avatar: "https://randomuser.me/api/portraits/men/6.jpg",
    messages: [
      { text: "Let me know when you're free.", timestamp: new Date('2025-04-29T09:00:00'), read: true, fromMe: false },
      { text: "Want to talk about the new project.", timestamp: new Date('2025-04-29T09:05:00'), read: true, fromMe: false },
      { text: "Ping me anytime today.", timestamp: new Date('2025-04-29T09:10:00'), read: false, fromMe: false }
    ]
  },
  {
    name: "Study Group",
    avatar: "https://randomuser.me/api/portraits/women/4.jpg",
    messages: [
      { text: "Final exam on Friday", timestamp: new Date('2025-04-27T13:00:00'), read: false, fromMe: false },
      { text: "Maria: I'll bring snacks", timestamp: new Date('2025-04-27T13:10:00'), read: false, fromMe: false },
      { text: "Tom: Can someone share notes?", timestamp: new Date('2025-04-27T13:15:00'), read: false, fromMe: false },
      { text: "Sure, I'll upload mine tonight.", timestamp: new Date('2025-04-27T13:30:00'), read: true, fromMe: true }
    ]
  },
  {
    name: "Olivia Brown",
    avatar: "https://randomuser.me/api/portraits/women/5.jpg",
    messages: [
      { text: "The restaurant was amazing!", timestamp: new Date('2025-04-25T18:00:00'), read: true, fromMe: false },
      { text: "We should go there again soon 😊", timestamp: new Date('2025-04-25T18:15:00'), read: true, fromMe: false },
      { text: "Next weekend?", timestamp: new Date('2025-04-25T18:30:00'), read: true, fromMe: false }
    ]
  },
  {
    name: "Bank Alerts",
    avatar: "https://randomuser.me/api/portraits/men/7.jpg",
    messages: [
      { text: "Reminder: Credit card payment due in 3 days", timestamp: new Date('2025-04-20T09:00:00'), read: true, fromMe: false },
      { text: "Auto payment enabled", timestamp: new Date('2025-04-20T09:30:00'), read: true, fromMe: false },
      { text: "Thank you for your payment", timestamp: new Date('2025-04-20T10:00:00'), read: true, fromMe: false }
    ]
  }
])

// Function to format the time based on today, yesterday, or full date
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

// Computed property to calculate unread messages count and format time
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
