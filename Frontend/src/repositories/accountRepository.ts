import axios from "axios";

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export const AccountRepository = {
  get(search: string = "", page: number = 1) {
    const params: Record<string, any> = { page };
    if (search) {
      params.search = search;
    }
    return axios.get(`${API_BASE_URL}/accounts`, { params });
  },
  post(data: any) {
    return axios.post(`${API_BASE_URL}/accounts`, data);
  }
};
