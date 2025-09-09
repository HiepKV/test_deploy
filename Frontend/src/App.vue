<script setup lang="ts">

import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import { computed } from 'vue';
// Import CompanyList từ thư mục company
import CompanyList from './components/company/CompanyList.vue';
// Import Sidebar từ thư mục common
import Sidebar from './components/common/Sidebar.vue';
import { useRoute } from 'vue-router';
const route = useRoute();
const hideSidebar = computed(() => route.path.startsWith('/formanswer'));
</script>

<template>
  <div class="container-fluid h-100">
    <div class="row">
      <!-- Ẩn Sidebar nếu route bắt đầu bằng /formanswer -->
      <Sidebar 
        v-if="!hideSidebar" 
        class="col-md-2" 
      />

      <div :class="!hideSidebar ? 'col-md-10' : 'col-md-12'">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<style>
#app {
  display: flex;
}
</style>
