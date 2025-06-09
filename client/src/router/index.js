import { createRouter, createWebHistory } from 'vue-router'

import AppLayout from '../layouts/AppLayout.vue'
import ChatsView from '../views/ChatsView.vue'
import GroupsView from '../views/GroupsView.vue'
import ProfileView from '../views/ProfileView.vue'
import MoreView from '../views/MoreView.vue'

import Login from '../views/Login.vue'
import Register from '../views/Register.vue'

import AddFriendsView from '../views/AddFriendsView.vue'
import FriendsRequestsView from '../views/FriendsRequestsView.vue'
import FriendsListView from '../views/FriendsListView.vue'

const routes = [
  // Public
  { path: '/login', component: Login },
  { path: '/register', component: Register },

  // Private (in layout)
  {
    path: '/',
    component: AppLayout,
    children: [
      { path: '', redirect: '/chats' },
      { path: 'chats/:chatId?', component: ChatsView },
      { path: 'groups', component: GroupsView },
      { path: 'profile', component: ProfileView },
      { path: 'more', component: MoreView },

      // New pages
      { path: 'add-friends', component: AddFriendsView },
      { path: 'friend-requests', component: FriendsRequestsView },
      { path: 'friends', component: FriendsListView }
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

function isAuthenticated() {
  return !!localStorage.getItem('token')
}

router.beforeEach((to, from, next) => {
  const publicPages = ['/login', '/register']
  const authRequired = !publicPages.includes(to.path)
  const loggedIn = isAuthenticated()

  if (authRequired && !loggedIn) {
    return next('/login')
  }

  next()
})

export default router
