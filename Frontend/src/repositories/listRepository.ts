import axios from "axios";
const API = import.meta.env.VITE_API_BASE_URL;

export const ListRepository = {
    async importList(file : File) {
        const formData = new FormData();
        formData.append("file", file);

        return await axios.post(`${API}/import-excel-result`, formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            },
        });
    },
        async importToSendMail(surveyId: number, file: File) {
        const formData = new FormData();
        formData.append("survey_id", surveyId.toString());
        formData.append("file", file);

        return await axios.post(`${API}/import-excel`, formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });
    },
        async exportExcel() {
            return await axios.get(`${API}/export-excel`, {
            responseType: "blob", 
        });
    },
};
