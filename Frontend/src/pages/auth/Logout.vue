<template>
  <div class="logout-overlay">
    <div class="logout-box">
      <h4 class="fw-bold text-center mb-2">ログアウト</h4>
      <p class="text-center mb-4">本当にログアウトしますか？</p>

      <div class="d-flex justify-content-center gap-3">
        <button
          class="btn btn-secondary px-4"
          @click="cancelLogout"
        >
          キャンセル
        </button>
        <button
          class="btn btn-danger px-4"
          @click="confirmLogout"
        >
          ログアウトする
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import { useAuthStore } from "@/store/auth/authStore";
import { nextTick } from "vue";
const authStore = useAuthStore();
const router = useRouter();

const confirmLogout = () => {
  localStorage.removeItem('token');
  
  authStore.logout(); 

  nextTick(() => {
    router.push('/login');
  });
};

const cancelLogout = () => {
  router.push("/companies"); 
};
</script>

<style scoped>
.logout-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.75);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1050;
}

.logout-box {
  background: white;
  padding: 24px;
  border-radius: 6px;
  width: 520px;
  height: 220px;
  text-align: center;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}
</style>
