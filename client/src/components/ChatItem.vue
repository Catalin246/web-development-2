<template>
    <div class="flex items-center px-4 py-3 hover:bg-gray-50 cursor-pointer">
      <img :src="avatar" alt="Avatar" class="w-12 h-12 rounded-full mr-4" />
      <div class="flex-1 p-2">
        <div class="flex justify-between items-center pb-1">
          <h2 class="font-semibold text-base">{{ name }}</h2>
          <span class="text-ms text-gray-500">{{ time || date }}</span>
        </div>
        <div class="flex justify-between items-center">
          <p class="text-ms text-gray-600 truncate w-[200px]">{{ message }}</p>
          <span 
            v-if="unread > 0" 
            class="text-xs bg-blue-500 text-white rounded-full w-6 h-6 flex items-center justify-center"
          >
            {{ unread }}
          </span>
          <!-- Empty span to maintain layout when no unread messages -->
          <span v-else class="w-6 h-6"></span>
        </div> 
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({
    name: String,
    message: String,
    time: String,
    date: String,
    unread: {
      type: Number,
      default: 0
    },
    avatar: String
  })
  </script>