import axios from "axios";

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export const CompanyRepository = {
  async getAll(search: string = "", page: number = 1) {
    const params: Record<string, any> = { page };
    if (search) {
      params.search = search;
    }
    return await axios.get(`${API_BASE_URL}/companies`, { params });
  },
  async getById(id: number) {
    return await axios.get(`${API_BASE_URL}/companies/${id}`);
  }
};
