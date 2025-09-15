import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router';
import homeRoutes from './routes/home';
import authRoutes from './routes/auth';
import CompanyList from '@/components/company/CompanyList.vue';
import CompanyCreate from '@/components/company/CompanyCreate.vue';
import SurveyList from '@/components/survey/SurveyList.vue';
import AccountList from '@/components/account/AccountList.vue';
import AccountCreate from '@/components/account/AccountCreate.vue';
import DetailSurvey from '@/components/survey/DetailSurvey.vue';
import FirstStep from '@/components/survey/createSurvey/FirstStep.vue';
import CreateSurvey from '@/components/survey/createSurvey/CreateSurvey.vue';
import SecondStep from '@/components/survey/createSurvey/SecondStep.vue';
import ThirdStep from '@/components/survey/createSurvey/ThirdStep.vue';
import FourthStep from '@/components/survey/createSurvey/FourthStep.vue';
import FifthStep from '@/components/survey/createSurvey/FifthStep.vue';
import LastStep from '@/components/survey/createSurvey/LastStep.vue';
import ImportList from '@/components/lists/ImportList.vue';
import PreviewSurvey from '@/components/recipient/PreviewSurvey.vue';
import MainSyrvey from '@/components/recipient/MainSyrvey.vue';

const routes: Array<RouteRecordRaw> = [
  ...authRoutes, // Login, Register

  // Các route yêu cầu đăng nhập
  { path: '/companies', component: CompanyList, meta: { requiresAuth: true } },
  { path: '/companies/create', component: CompanyCreate, meta: { requiresAuth: true } },
  { path: '/surveys', component: SurveyList, meta: { requiresAuth: true } },
  { path: '/surveys/:id', component: DetailSurvey, meta: { requiresAuth: true } },
  { 
    path: '/surveys/create', 
    component: CreateSurvey,
    meta: { requiresAuth: true },
    children: [
      { path: '', component: FirstStep },
      { path: 'step2', component: SecondStep },
      { path: 'step3', component: ThirdStep },
      { path: 'step4', component: FourthStep },
      { path: 'step5', component: FifthStep },
    ]
  },
  { path: '/laststep', component: LastStep, meta: { requiresAuth: true } },
  { path: '/accounts', component: AccountList, meta: { requiresAuth: true } },
  { path: '/accounts/create', component: AccountCreate, meta: { requiresAuth: true } },
  { path: '/lists', component: ImportList, meta: { requiresAuth: true } },
  { path: '/formanswer/preview/:id', component: PreviewSurvey, meta: { requiresAuth: true } },
  { path: '/formanswer/main/:id', component: MainSyrvey },
  { path: '/logout', component: Logout, meta: { requiresAuth: true } },
];


import { useAuthStore } from '@/store/auth/authStore';
import Logout from '@/pages/auth/Logout.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next({ path: '/login' });
  } else if (to.path === '/login' && authStore.isAuthenticated) {
    next({ path: '/companies' });
  } else {
    next();
  }
});
// router.beforeEach((to, from, next) => {
//   const meta = metaConfig[to.path];

//   // Set the document title
//   if (meta?.title) {
//     document.title = meta.title;
//   }

//   // Remove existing meta tags controlled by Vue Router
//   const existingMetaTags = document.querySelectorAll('[data-vue-router-controlled]');
//   existingMetaTags.forEach((tag) => tag.parentNode?.removeChild(tag));

//   // Add new meta tags
//   if (meta?.meta) {
//     meta.meta.forEach(({ name, content }) => {
//       const tag = document.createElement('meta');
//       tag.setAttribute('name', name);
//       tag.setAttribute('content', content);
//       tag.setAttribute('data-vue-router-controlled', ''); // Mark for cleanup
//       document.head.appendChild(tag);
//     });
//   }

//   next();
// });



export default router;
