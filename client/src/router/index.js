// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'

import AppLayout from '../layouts/AppLayout.vue'
import ChatsView from '../views/ChatsView.vue'
import GroupsView from '../views/GroupsView.vue'
import ProfileView from '../views/ProfileView.vue'
import MoreView from '../views/MoreView.vue'
import FriendRequest from '../views/FriendRequest.vue'
import Login from '../views/Login.vue'
import Register from '../views/Register.vue'

const routes = [
  // Public pages (outside layout)
  { path: '/login', component: Login },
  { path: '/register', component: Register },

  // Layout wrapper
  {
    path: '/',
    component: AppLayout,
    children: [
      { path: '', redirect: '/chats' },
      { path: 'chats', component: ChatsView },
      { path: 'groups', component: GroupsView },
      { path: 'profile', component: ProfileView },
      { path: 'more', component: MoreView },
      { path: 'friend-request', component: FriendRequest }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
