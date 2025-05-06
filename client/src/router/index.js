import { createRouter, createWebHistory } from 'vue-router'
import ChatsView from '../views/ChatsView.vue'
import GroupsView from '../views/GroupsView.vue'
import ProfileView from '../views/ProfileView.vue'
import MoreView from '../views/MoreView.vue'

const routes = [
  { path: '/', redirect: '/chats' },
  { path: '/chats', component: ChatsView },
  { path: '/groups', component: GroupsView },
  { path: '/profile', component: ProfileView },
  { path: '/more', component: MoreView },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
