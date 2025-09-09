import { SurveyRepository } from "@/repositories/surveyRepository";
import { create } from "domain";
export const SurveyService = {
    async getAll(search: string = "", page: number = 1) {
        const response = await SurveyRepository.getAll(search, page);
        return {
          data: response.data.data || [],
          totalPages: response.data.last_page || 1,
        };
      },
      async getById(id: number){
        return await SurveyRepository.getById(id);
      },
      async createSur(data : any){
        return await SurveyRepository.createSurvey(data);
      }
}