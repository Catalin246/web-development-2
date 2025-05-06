<template>
  <div class="flex flex-col h-[calc(90%)] md:h-full bg-white rounded-lg">
    <!-- Chat Header -->
    <div class="flex items-center justify-between p-4 border-b bg-blue-50">
      <div class="flex items-center gap-4">
        <img :src="chat.avatar" alt="avatar" class="w-10 h-10 rounded-full" />
        <h2 class="font-semibold text-lg">{{ chat.name }}</h2>
      </div>
      <span class="text-sm text-gray-500">{{ chat.time }}</span>
    </div>

    <!-- Messages Area -->
    <div class="flex-1 overflow-y-auto p-4 space-y-2 flex flex-col">
      <div
        v-for="(message, index) in chat.messages"
        :key="index"
        :class="[ 
          'px-4 py-3 rounded-xl max-w-[50%]', 
          message.fromMe 
            ? 'self-end bg-blue-100 text-right' 
            : 'self-start bg-gray-100 text-left'
        ]"
        class="flex items-center space-x-2"
      >
        <!-- Avatar for received messages (left) -->
        <img
          v-if="!message.fromMe"
          :src="chat.avatar"
          alt="Avatar"
          class="w-6 h-6 rounded-full"
        />

        <!-- Message Text -->
        <div :class="message.fromMe ? 'ml-2' : 'mr-2'">
          {{ message.text }}
        </div>

        <!-- Avatar for sent messages (right) -->
        <img
          v-if="message.fromMe"
          :src="chat.avatar"
          alt="Avatar"
          class="w-6 h-6 rounded-full"
        />
      </div>
    </div>

    <!-- Message Input -->
    <div class="border-t pt-4">
      <input
        type="text"
        placeholder="Type your message..."
        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300"
      />
    </div>
  </div>
</template>

<script setup>
defineProps({
  chat: Object
})
</script>
