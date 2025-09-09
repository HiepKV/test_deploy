import axios from "axios";

export const CompanyRepository = {
    async getAll(search: string = "", page: number = 1) {
        const params: Record<string, any> = { page };
        if (search) {
            params.search = search;
        }
        return await axios.get(`http://127.0.0.1:8000/api/companies`, { params });
    },
    async getById(id: number) {
        return await axios.get(`http://127.0.0.1:8000/api/companies/${id}`)
    }
}