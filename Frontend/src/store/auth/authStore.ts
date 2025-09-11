// src/stores/authStore.ts
import { defineStore } from 'pinia';
import { ref, computed } from 'vue';

export const useAuthStore = defineStore('auth', () => {
  const token = ref<string | null>(localStorage.getItem('token'));

  const login = (accessToken: string) => {
    token.value = accessToken;
    localStorage.setItem('token', accessToken);
  };

  const logout = () => {
    token.value = null;
    localStorage.removeItem('token');
  };

  const isAuthenticated = computed(() => !!token.value);

  return {
    token,
    login,
    logout,
    isAuthenticated,
  };
});
