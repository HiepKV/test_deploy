import { RouteRecordRaw } from 'vue-router';
import Home from '@/pages/home/index.vue';

const homeRoutes: Array<RouteRecordRaw> = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  // Add other routes related to the home here
];

export default homeRoutes;
