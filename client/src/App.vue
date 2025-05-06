<script setup>
import ChatItem from './components/ChatItem.vue'
import NavIcon from './components/NavIcon.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faSearch, faPlus } from '@fortawesome/free-solid-svg-icons'
</script>

<template>
  <div class="min-h-screen bg-blue-100 flex flex-col">
    <div class="flex-grow flex justify-center">
      <div class="w-full bg-white p-1 shadow-md flex flex-col" style="max-height: 100vh;">
        <!-- Header -->
        <header class="bg-blue-600 text-white p-6 flex justify-between items-center rounded-b-2xl">
          <div class="flex items-center">
            <!-- <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="..." />
            </svg> -->
            <h1 class="font-medium text-xl">Chat App</h1>
          </div>
          <div class="flex items-center gap-2">
            <div class="flex items-center gap-2">
              <button>
                <FontAwesomeIcon :icon="faSearch" class="w-5 h-5 text-4xl px-2" />
              </button>
              <button>
                <FontAwesomeIcon :icon="faPlus" class="w-5 h-5 text-4xl px-2" />
              </button>
            </div>
          </div>
        </header>

        <!-- Chat List -->
        <main class="divide-y overflow-y-auto flex-grow p-1">
          <ChatItem
            name="Sarah Johnson"
            message="Hey, are we still meeting tomorrow at the coffee shop?"
            time="09:15"
            unread="2"
            avatar="https://randomuser.me/api/portraits/women/1.jpg"
          />
          <ChatItem
            name="Tech Support"
            message="Your ticket #4567 has been resolved. Please confirm if everything works now."
            time="Yesterday"
            unread="1"
            avatar="https://randomuser.me/api/portraits/men/1.jpg"
          />
          <ChatItem
            name="Mom"
            message="Don't forget about family dinner this Sunday! 🍗"
            time="Yesterday"
            unread="0"
            avatar="https://randomuser.me/api/portraits/women/2.jpg"
          />
          <ChatItem
            name="Alex Taylor"
            message="Just sent you the project files. Let me know what you think!"
            time="11/05"
            unread="3"
            avatar="https://randomuser.me/api/portraits/men/2.jpg"
          />
          <ChatItem
            name="Work Group"
            message="Meeting moved to 3pm | Jenny: I'll be late | Mike: Got it"
            time="10/05"
            unread="12"
            avatar="https://randomuser.me/api/portraits/men/3.jpg"
          />
          <ChatItem
            name="James Wilson"
            message="The design mockups look great! Just a few small changes needed..."
            time="08/05"
            unread="0"
            avatar="https://randomuser.me/api/portraits/men/4.jpg"
          />
          <ChatItem
            name="Emma Davis"
            message="Thanks for the birthday wishes! 🎉"
            time="05/05"
            unread="0"
            avatar="https://randomuser.me/api/portraits/women/3.jpg"
          />
          <ChatItem
            name="Delivery"
            message="Your package #12345 has been delivered"
            time="03/05"
            unread="0"
            avatar="https://randomuser.me/api/portraits/men/5.jpg"
          />
          <ChatItem
            name="David Miller"
            message="Let me know when you're free for a call about the new project"
            time="01/05"
            unread="1"
            avatar="https://randomuser.me/api/portraits/men/6.jpg"
          />
          <ChatItem
            name="Study Group"
            message="Final exam on Friday | Maria: I'll bring snacks | Tom: Can someone share notes?"
            time="28/04"
            unread="7"
            avatar="https://randomuser.me/api/portraits/women/4.jpg"
          />
          <ChatItem
            name="Olivia Brown"
            message="The restaurant was amazing! We should go there again soon 😊"
            time="25/04"
            unread="0"
            avatar="https://randomuser.me/api/portraits/women/5.jpg"
          />
          <ChatItem
            name="Bank Alerts"
            message="Reminder: Credit card payment due in 3 days"
            time="20/04"
            unread="0"
            avatar="https://randomuser.me/api/portraits/men/7.jpg"
          />
        </main>

        <!-- Bottom Nav -->
        <footer class="bg-white flex justify-around py-2 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1),0_-2px_4px_-1px_rgba(0,0,0,0.06)] rounded-t-2xl">
          <NavIcon label="Chats" active />
          <NavIcon label="Groups" />
          <NavIcon label="Profile" />
          <NavIcon label="More" />
        </footer>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>