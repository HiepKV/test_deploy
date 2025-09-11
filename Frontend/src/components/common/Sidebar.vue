<template>
  <div class="sidebar">
    <LangSwitcher />
    <h2 class="sidebar-title">{{ t('slideBar.dasboard') }}</h2>
    <ul class="sidebar-menu">
      <li :class="{ active: route.path.startsWith('/surveys') }">
        <router-link to="/surveys">{{ t('slideBar.SurveyList') }}</router-link>
      </li>
      <li :class="{ active: route.path.startsWith('/companies') }">
        <router-link to="/companies">{{ t('slideBar.companyList') }}</router-link>
      </li>
      <li :class="{ active: route.path.startsWith('/lists') }">
        <router-link to="/lists">{{ t('slideBar.list') }}</router-link>
      </li>
      <li :class="{ active: route.path.startsWith('/accounts') }">
        <router-link to="/accounts">{{ t('slideBar.accountList') }}</router-link>
      </li>
      <li :class="{ active: route.path.startsWith('/logout')}">
        <router-link to="/logout">{{ t('slideBar.logout') }}</router-link>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import LangSwitcher from "@/locales/LangSwitcher.vue";

const route = useRoute();
const { t } = useI18n();
</script>

<style scoped>
.sidebar {
  width: 250px;
  background-color: #f8f9fa;
  height: 100vh;
  padding: 20px;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
}

.sidebar-title {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 20px;
}

.sidebar-menu {
  list-style: none;
  padding: 0;
}

.sidebar-menu li {
  margin-bottom: 15px;
}

.sidebar-menu li a {
  text-decoration: none;
  color: #333;
  font-size: 16px;
}

.sidebar-menu li.active a {
  font-weight: bold;
  color: #007bff;
}
</style>
