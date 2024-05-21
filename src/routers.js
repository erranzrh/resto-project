import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home.vue';
import SignUp from './components/SignUp.vue';
import Login from './components/Login.vue';
import AddMenu from './components/AddMenu.vue';
import UpdateMenu from './components/UpdateMenu.vue';

const routes = [
  {
    name: 'Home',
    component: Home,
    path: '/'
  },
  {
    name: 'SignUp',
    component: SignUp,
    path: '/sign-up'
  },
  {
    name: 'Login',
    component: Login,
    path: '/login'
  },
  {
    name: 'AddMenu',
    component: AddMenu,
    path: '/add-menu'
  },
  {
    name: 'UpdateMenu',
    component: UpdateMenu,
    path: '/update-menu'
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
