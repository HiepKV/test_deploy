import axios from "axios";

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export const SurveyRepository = {
  async getAll(search: string = "", page: number = 1) {
    const token = localStorage.getItem("token"); // Lấy token từ localStorage
    const params: Record<string, any> = { page };
    if (search) {
      params.search = search;
    }

    return await axios.get(`${API_BASE_URL}/surveys`, {
      params,
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
  },

  async getById(id: number) {
    const token = localStorage.getItem("token");

    return await axios.get(`${API_BASE_URL}/surveys/${id}`, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
  },

  async createSurvey(data: any) {
    const token = localStorage.getItem("token");

    return await axios.post(`${API_BASE_URL}/surveys`, data, {
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "multipart/form-data",
      },
    });
  },
};
