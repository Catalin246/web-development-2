<script setup>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { 
  faComment, 
  faUsers, 
  faUser, 
  faEllipsisH 
} from '@fortawesome/free-solid-svg-icons'

defineProps(['label', 'active'])

// Get icon based on label
const getIcon = (label) => {
  switch(label) {
    case 'Chats': return faComment
    case 'Groups': return faUsers
    case 'Profile': return faUser
    case 'More': return faEllipsisH
    default: return faComment
  }
}
</script>

<template>
  <div class="flex flex-col items-center text-sm mt-3">
    <div 
      class="w-10 h-10 flex items-center justify-center rounded-full"
      :class="{ 'bg-blue-600': active, 'bg-gray-300': !active }"
    >
      <FontAwesomeIcon 
        :icon="getIcon(label)" 
        class="text-lg w-12 h-12 text-white" 
      />
    </div>
    <span :class="{ 'text-blue-600 font-medium': active, 'text-gray-500': !active }">
      {{ label }}
    </span>
  </div>
</template>