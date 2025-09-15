import api from "./api";
export const ListRepository = {
    async importList(file : File) {
        const formData = new FormData();
        formData.append("file", file);

        return await api.post(`/import-excel-result`, formData, {
            headers: {
                "Content-Type": "multipart/form-data"
            },
        });
    },
        async importToSendMail(surveyId: number, file: File) {
        const formData = new FormData();
        formData.append("survey_id", surveyId.toString());
        formData.append("file", file);

        return await api.post(`/import-excel`, formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });
    },
        async exportExcel() {
            return await api.get(`/export-excel`, {
            responseType: "blob", 
        });
    },
};
