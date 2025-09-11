<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow p-4" style="width: 360px; border-radius: 8px;">
      <!-- Tiêu đề -->
      <h3 class="text-center text-primary mb-4">Sign in</h3>

      <!-- Form Login -->
      <form @submit.prevent="handleLogin">
        <!-- Username -->
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input
            id="username"
            type="text"
            v-model="form.username"
            placeholder="IDを入力"
            class="form-control"
            required
          />
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input
            id="password"
            type="password"
            v-model="form.password"
            placeholder="パスワードを入力"
            class="form-control"
            required
          />
        </div>

        <!-- Hiển thị lỗi -->
        <div v-if="errorMessage" class="alert alert-danger py-2 text-center">
          {{ errorMessage }}
        </div>

        <!-- Nút Submit -->
        <button
          type="submit"
          class="btn btn-primary w-100"
          :disabled="loading"
        >
          <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
          {{ loading ? 'Loading...' : 'Sign in' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/store/auth/authStore";
import { AuthService } from "@/services/authService";

const router = useRouter();
const authStore = useAuthStore();

// State form
const form = reactive({
  username: "",
  password: "",
});

const loading = ref(false);
const errorMessage = ref("");

const handleLogin = async () => {
  loading.value = true;
  errorMessage.value = "";

  try {
    const response = await AuthService.login({
      username: form.username,
      password: form.password,
    });

    const token = response.data.access_token;

    authStore.login(token);
    localStorage.setItem("token", token);

    // Chuyển hướng tới trang chính
    router.push("/companies");
  } catch (error: any) {
    errorMessage.value = error.response?.data?.message || "Login failed";
  } finally {
    loading.value = false;
  }
};
</script>
