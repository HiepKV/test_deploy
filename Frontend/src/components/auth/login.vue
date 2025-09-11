<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded p-8 w-96">
      <h2 class="text-2xl font-semibold text-center text-blue-500 mb-6">
        Sign in
      </h2>

      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label class="block text-sm font-medium mb-1">Username</label>
          <input
            type="text"
            v-model="form.username"
            placeholder="IDを入力"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
        </div>
        <div class="mb-6">
          <label class="block text-sm font-medium mb-1">Password</label>
          <input
            type="password"
            v-model="form.password"
            placeholder="パスワードを入力"
            class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
            required
          />
        </div>
        <p v-if="errorMessage" class="text-red-500 text-sm mb-4 text-center">
          {{ errorMessage }}
        </p>
        <button
          type="submit"
          class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition"
          :disabled="loading"
        >
          {{ loading ? 'Loading...' : 'Sign in' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import { AuthService } from "@/services/authService";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

export default {
  setup() {
    const store = useStore();
    const router = useRouter();

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
        const token = response.data.token;
        store.dispatch("auth/login", token);
        localStorage.setItem("token", token);
        router.push("/dashboard");
      } catch (error) {
        errorMessage.value = error.response?.data?.message || "Login failed";
      } finally {
        loading.value = false;
      }
    };

    return {
      form,
      loading,
      errorMessage,
      handleLogin,
    };
  },
};
</script>

<style scoped>
/* Style custom nếu cần */
</style>
