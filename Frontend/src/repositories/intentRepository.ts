import axios from "axios";
import api from "./api";
const API = import.meta.env.VITE_API_BASE_URL;

export const IntentRepository = {
    async post(data : any){
        return await api.post(`/recipients`, data, {
            headers: { 'Content-Type': 'application/json' },
        })
    }
}