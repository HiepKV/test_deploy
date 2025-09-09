import axios from "axios";

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export const AccountRepository = {
  get(search: string = "", page: number = 1) {
    const params: Record<string, any> = { page };
    if (search) {
      params.search = search;
    }
    return axios.get(`http://127.0.0.1:8000/api/accounts`, { params });
  },
  post(data: any){
    return axios.post(`http://127.0.0.1:8000/api/accounts`, data)
  }
};