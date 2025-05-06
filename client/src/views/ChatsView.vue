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
  },
  {
    type: 'normal',
    name: "Liam Parker",
    avatar: "https://randomuser.me/api/portraits/men/5.jpg",
    participants: [
      { id: 1, name: userName, avatar: 'https://randomuser.me/api/portraits/men/8.jpg' },
      { id: 5, name: 'Liam Parker', avatar: 'https://randomuser.me/api/portraits/men/5.jpg' }
    ],
    messages: Array.from({ length: 8 }, (_, i) => ({
      text: `Message ${i + 1} from ${i % 2 === 0 ? 'Liam' : userName}`,
      timestamp: new Date(`2025-05-06T0${i + 1}:00:00`),
      read: true,
      from: i % 2 === 0 ? 5 : 1
    }))
  },
  {
    type: 'normal',
    name: "Emma Williams",
    avatar: "https://randomuser.me/api/portraits/women/6.jpg",
    participants: [
      { id: 1, name: userName, avatar: 'https://randomuser.me/api/portraits/men/8.jpg' },
      { id: 6, name: 'Emma Williams', avatar: 'https://randomuser.me/api/portraits/women/6.jpg' }
    ],
    messages: Array.from({ length: 8 }, (_, i) => ({
      text: `Chat with Emma, msg ${i + 1}`,
      timestamp: new Date(`2025-05-05T1${i}:00:00`),
      read: i < 10,
      from: i % 2 === 0 ? 6 : 1
    }))
  },
  {
    type: 'group',
    name: "Gaming Squad",
    avatar: "https://randomuser.me/api/portraits/men/6.jpg",
    participants: [
      { id: 1, name: userName, avatar: 'https://randomuser.me/api/portraits/men/8.jpg' },
      { id: 7, name: 'Alex', avatar: 'https://randomuser.me/api/portraits/men/7.jpg' },
      { id: 8, name: 'Zoe', avatar: 'https://randomuser.me/api/portraits/women/3.jpg' }
    ],
    messages: [
      { text: "Who's online tonight?", timestamp: new Date('2025-05-06T08:00:00'), read: false, from: 7 },
      { text: "I'll be on after 9.", timestamp: new Date('2025-05-06T08:10:00'), read: false, from: 8 },
      { text: "Same here", timestamp: new Date('2025-05-06T08:12:00'), read: true, from: 1 }
    ]
  },
  {
    type: 'normal',
    name: "Noah Martinez",
    avatar: "https://randomuser.me/api/portraits/men/9.jpg",
    participants: [
      { id: 1, name: userName, avatar: 'https://randomuser.me/api/portraits/men/8.jpg' },
      { id: 9, name: 'Noah Martinez', avatar: 'https://randomuser.me/api/portraits/men/9.jpg' }
    ],
    messages: [
      { text: "Lunch tomorrow?", timestamp: new Date('2025-05-05T12:00:00'), read: true, from: 9 }
    ]
  },
  {
    type: 'normal',
    name: "Olivia Brown",
    avatar: "https://randomuser.me/api/portraits/women/7.jpg",
    participants: [
      { id: 1, name: userName, avatar: 'https://randomuser.me/api/portraits/men/8.jpg' },
      { id: 10, name: 'Olivia Brown', avatar: 'https://randomuser.me/api/portraits/women/7.jpg' }
    ],
    messages: [
      { text: "Can you review my resume?", timestamp: new Date('2025-05-04T14:00:00'), read: false, from: 10 }
    ]
  },
  {
    type: 'normal',
    name: "Ethan Davis",
    avatar: "https://randomuser.me/api/portraits/men/10.jpg",
    participants: [
      { id: 1, name: userName, avatar: 'https://randomuser.me/api/portraits/men/8.jpg' },
      { id: 11, name: 'Ethan Davis', avatar: 'https://randomuser.me/api/portraits/men/10.jpg' }
    ],
    messages: [
      { text: "Final exam schedule?", timestamp: new Date('2025-05-03T10:00:00'), read: true, from: 11 }
    ]
  },
  {
    type: 'normal',
    name: "Chloe Wilson",
    avatar: "https://randomuser.me/api/portraits/women/8.jpg",
    participants: [
      { id: 1, name: userName, avatar: 'https://randomuser.me/api/portraits/men/8.jpg' },
      { id: 12, name: 'Chloe Wilson', avatar: 'https://randomuser.me/api/portraits/women/8.jpg' }
    ],
    messages: [
      { text: "Let's plan a trip!", timestamp: new Date('2025-05-02T09:00:00'), read: false, from: 12 }
    ]
  },
  {
    type: 'normal',
    name: "Daniel Lee",
    avatar: "https://randomuser.me/api/portraits/men/12.jpg",
    participants: [
      { id: 1, name: userName, avatar: 'https://randomuser.me/api/portraits/men/8.jpg' },
      { id: 13, name: 'Daniel Lee', avatar: 'https://randomuser.me/api/portraits/men/12.jpg' }
    ],
    messages: [
      { text: "Did you get the report?", timestamp: new Date('2025-05-01T08:30:00'), read: true, from: 13 }
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
