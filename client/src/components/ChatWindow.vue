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
          'flex items-end',
          message.from === 1 ? 'justify-end' : 'justify-start'
        ]"
      >
        <!-- Left side avatar for others -->
        <img
          v-if="message.from !== 1"
          :src="chat.participants.find(p => p.id === message.from)?.avatar"
          alt="Avatar"
          class="w-6 h-6 rounded-full mr-2"
        />

        <!-- Message Bubble -->
        <div
          :class="[
            'px-4 py-3 rounded-xl max-w-[70%]',
            message.from === 1 ? 'bg-blue-100 text-right' : 'bg-gray-100 text-left'
          ]"
        >
          <div class="text-sm">{{ message.text }}</div>
          <div class="text-xs text-gray-500 mt-1">{{ message.formattedTime }}</div>
        </div>

        <!-- Right side avatar for self -->
        <img
          v-if="message.from === 1"
          :src="chat.participants.find(p => p.id === message.from)?.avatar"
          alt="Avatar"
          class="w-6 h-6 rounded-full ml-2"
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
