import { IntentRepository } from "@/repositories/intentRepository";

export const IntentService = {
    async post(data : any){
        return await IntentRepository.post(data);
    },
};