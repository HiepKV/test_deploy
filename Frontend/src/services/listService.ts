import { ListRepository } from "@/repositories/listRepository";

export const ListService = {
    async importList(file : File){
        return await ListRepository.importList(file);
    },
    async importToSendMail(surveyId : number, file : File){
        return await ListRepository.importToSendMail(surveyId, file);
    },
    async exportExcel() {
        return await ListRepository.exportExcel();
    },
};