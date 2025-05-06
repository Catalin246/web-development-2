<template>
  <div class="flex items-center gap-4 p-4 hover:bg-gray-100 cursor-pointer">
    <img :src="avatar" alt="avatar" class="w-12 h-12 rounded-full" />
    <div class="flex-1">
      <div class="flex justify-between">
        <span class="font-semibold">{{ name }}</span>
        <span class="text-xs text-gray-500">{{ time }}</span>
      </div>
      <div class="flex justify-between items-center">
        <span class="text-sm text-gray-700 truncate w-full">
          {{ lastMessage?.text || 'No messages yet' }}
        </span>
        <span v-if="unread > 0" class="bg-blue-500 text-white text-xs rounded-full px-2 ml-2">
          {{ unread }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  name: String,
  avatar: String,
  time: String,
  unread: Number,
  lastMessage: Object
})
</script>
