import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home.vue';
import SignUp from './components/SignUp.vue';
import Login from './components/Login.vue';
import AddMenu from './components/AddMenu.vue';
import UpdateMenu from './components/UpdateMenu.vue';
import AdminMenu from './components/AdminMenu.vue';
import CustomerMenu from './components/CustomerMenu.vue';
import ShoppingCart from './components/Cart.vue';
import Report from './components/ReportAnalysis.vue';
// import OrderHistory from './components/History.vue';

const routes = [
  { name: 'Home', component: Home, path: '/' },
  { name: 'SignUp', component: SignUp, path: '/sign-up' },
  { name: 'Login', component: Login, path: '/login' },
  { name: 'AddMenu', component: AddMenu, path: '/add-menu' },
  { name: 'UpdateMenu', component: UpdateMenu, path: '/update-menu/:id' },
  { name: 'AdminMenu', component: AdminMenu, path: '/admin-menu' },
  { name: 'CustomerMenu', component: CustomerMenu, path: '/customer-menu' },
  { name: 'Cart', component: ShoppingCart, path: '/cart' },
  { name: 'Report', component: Report, path: '/report' },
  // { name: 'OrderHistory', component: OrderHistory, path: '/order-history' }
];

const router = createRouter({ history: createWebHistory(), routes });
export default router;
