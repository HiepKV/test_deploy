import axios from "axios";

export const SurveyRepository = {
    async getAll(search: string = "", page: number = 1) {
        const params: Record<string, any> = { page };
        if (search) {
            params.search = search;
        }
        return await axios.get(`http://127.0.0.1:8000/api/surveys`, { params });
    },
    async getById(id: number) {
        return await axios.get(`http://127.0.0.1:8000/api/surveys/${id}`)
    },
    async createSurvey(data : any) {
        return await axios.post('http://127.0.0.1:8000/api/surveys', data,{
            headers:{ "Content-Type": "multipart/form-data" }
        })
    }
}