<template>
  <div class="flex items-center gap-4 p-5 hover:bg-gray-100 cursor-pointer relative group">
    <!-- Avatar -->
    <img :src="avatar" alt="avatar" class="w-12 h-12 rounded-full" />

    <!-- Info -->
    <div class="md:max-w-39 flex-1">
      <div class="flex justify-between">
        <span class="font-semibold">{{ name.length > 12 ? name.slice(0, 12) + '...' : name }}</span>
        <span class="text-xs text-gray-500">{{ time }}</span>
      </div>
      <div class="flex justify-between items-center">
        <span class="text-sm text-gray-700 truncate w-full">
          {{
            lastMessage?.text
              ? lastMessage.text.length > 25
                ? lastMessage.text.slice(0, 25) + '...'
                : lastMessage.text
              : 'No messages yet'
          }}
        </span>
        <span
          v-if="unread > 0"
          class="bg-blue-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center ml-2"
        >
          {{ unread }}
        </span>
      </div>
    </div>

    <!-- 3 Dots Button -->
    <button
      @click.stop="toggleDropdown"
      class="p-2 rounded-full hover:bg-gray-200 ml-2"
    >
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M12 12v.01M12 18v.01" />
      </svg>
    </button>

    <!-- Dropdown -->
    <div
      v-if="showDropdown"
      class="absolute p-1 py-3 right-4 top-full w-40 bg-white rounded shadow-md z-20"
      style="top: calc(100%);"
    >
      <ul class="text-sm text-gray-700">
        <li @click="emitAction('open')" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Open Chat</li>
        <li @click="emitAction('mute')" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">Mute Notifications</li>
        <li @click="emitAction('more')" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">More Info</li>
        <li @click="emitAction('delete')" class="px-4 py-2 text-red-600 hover:bg-red-100 cursor-pointer">Delete Chat</li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const props = defineProps({
  name: String,
  avatar: String,
  time: String,
  unread: Number,
  lastMessage: Object
})

const emit = defineEmits(['action'])

const showDropdown = ref(false)

function toggleDropdown() {
  showDropdown.value = !showDropdown.value
}

function emitAction(type) {
  emit('action', type)
  showDropdown.value = false
}

function handleClickOutside(e) {
  if (!e.target.closest('.group')) {
    showDropdown.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>
