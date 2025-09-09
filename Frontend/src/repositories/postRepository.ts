import apiClient from "../plugins/axios";

export const postRepository = {
  async getPosts() {
    const response = await apiClient.get('/posts');
    return response.data;
  },
  async createPost(postData: object) {
    const response = await apiClient.post('/posts', postData);
    return response.data;
  },
};
