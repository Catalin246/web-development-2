<template>
    <div class="h-full flex flex-col">
      <!-- Chat Header -->
      <div class="flex items-center p-4 border-b bg-white">
        <img :src="chat.avatar" class="w-10 h-10 rounded-full" />
        <div class="ml-4">
          <h2 class="font-semibold">{{ chat.name }}</h2>
          <p class="text-sm text-gray-500">Online</p>
        </div>
      </div>
  
      <!-- Messages Container -->
      <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">
        <!-- Example Message -->
        <div class="flex justify-end">
          <div class="bg-blue-500 text-white p-3 rounded-lg max-w-[70%]">
            <p>Hey, are we still meeting tomorrow at the coffee shop?</p>
            <span class="text-xs text-blue-100 mt-1 block">09:15</span>
          </div>
        </div>
  
        <!-- Add more messages here -->
      </div>
  
      <!-- Message Input -->
      <div class="p-4 border-t bg-white">
        <div class="flex items-center space-x-2">
          <input
            type="text"
            placeholder="Type a message..."
            class="flex-1 p-2 border rounded-lg focus:outline-none focus:border-blue-500"
          />
          <button class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600">
            Send
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({
    chat: Object
  })
  </script>

  