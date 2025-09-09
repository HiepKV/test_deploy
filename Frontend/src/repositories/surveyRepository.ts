import axios from "axios";

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL; // lấy từ .env

export const SurveyRepository = {
    async getAll(search: string = "", page: number = 1) {
        const params: Record<string, any> = { page };
        if (search) {
            params.search = search;
        }
        return await axios.get(`${API_BASE_URL}/surveys`, { params });
    },
    async getById(id: number) {
        return await axios.get(`${API_BASE_URL}/surveys/${id}`);
    },
    async createSurvey(data: any) {
        return await axios.post(`${API_BASE_URL}/surveys`, data, {
            headers: { "Content-Type": "multipart/form-data" },
        });
    },
};
