import apiClient from "@/plugins/axios";

export const userRepository = {
  async getAllUsers() {
    const response = await apiClient.get('/users');
    return response.data;
  },
  async getUserById(userId: number) {
    const response = await apiClient.get(`/users/${userId}`);
    return response.data;
  },
  async createUser(userData: object) {
    const response = await apiClient.post('/users', userData);
    return response.data;
  },
};
