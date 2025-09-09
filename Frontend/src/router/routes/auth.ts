import { RouteRecordRaw } from 'vue-router';
import Login from '@/pages/auth/Login.vue';

const authRoutes: Array<RouteRecordRaw> = [
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  // Add other routes related to authentication here
];

export default authRoutes;
