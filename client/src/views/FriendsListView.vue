<template>
  <div class="p-4 py-6 md:p-16 md:py-10 w-full">
    <h2 class="text-2xl font-semibold mb-4">Your Friends</h2>

    <ul v-if="friends.length > 0" class="space-y-2">
      <li
        v-for="friend in friends"
        :key="friend.id"
        class="flex justify-between items-center p-2 bg-green-100 rounded-md"
      >
        <div class="flex items-center space-x-4">
          <img :src="friend.avatar" alt="avatar" class="w-8 h-8 rounded-full" />
          <span>{{ friend.name }}</span>
        </div>
        <button
          class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
          @click="startChatWith(friend)"
        >
          Chat
        </button>
      </li>
    </ul>

    <p v-else class="text-gray-500 italic mt-4">
      You have no friends yet. Try adding some!
    </p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const friends = ref([])
const currentUser = ref(null)
const urlValue = import.meta.env.VITE_API_URL

const fetchFriends = async () => {
  try {
    const response = await axios.get(`${urlValue}/friends/list`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    friends.value = response.data
  } catch (error) {
    console.error('Failed to fetch friends:', error)
  }
}

const fetchCurrentUser = async () => {
  try {
    const response = await axios.get(`${urlValue}/auth/me`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    })
    currentUser.value = response.data
  } catch (error) {
    console.error('Failed to fetch current user:', error)
  }
}

const startChatWith = async (friend) => {
  if (!currentUser.value) return;

  try {
    const chatsResponse = await axios.get(`${urlValue}/chats`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });

    const chats = Array.isArray(chatsResponse.data)
      ? chatsResponse.data
      : chatsResponse.data.chats || [];
      
    const existingChat = chats.find(chat => {
      const participantIds = chat.participants?.map(p => p.id) || [];
      return participantIds.includes(currentUser.value.id) &&
             participantIds.includes(friend.id) &&
             participantIds.length === 2;
    });

    if (existingChat) {
      router.push(`/chats/${existingChat.id}`);
      return;
    }

    const payload = {
      participant_ids: [currentUser.value.id, friend.id],
      name: `${friend.name}`,
    };

    const createResponse = await axios.post(`${urlValue}/chats`, payload, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`,
      },
    });

    console.log('Create chat response:', createResponse.data);

    // Try to get chat id from known response structures
    const newChatId = createResponse.data.id || createResponse.data.chat?.id;

    if (newChatId) {
      router.push(`/chats/${newChatId}`);
    } else {
      console.warn('Chat ID not found in create response. Redirecting to /chats');
      router.push(`/chats`);
    }

  } catch (error) {
    console.error('Failed to check or create chat:', error.response?.data || error.message);
  }
}

onMounted(() => {
  fetchCurrentUser()
  fetchFriends()
})
</script>
