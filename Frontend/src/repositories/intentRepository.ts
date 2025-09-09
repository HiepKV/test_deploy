import axios from "axios";

const API = import.meta.env.VITE_API_BASE_URL;

export const IntentRepository = {
    async post(data : any){
        return await axios.post(`${API}/recipients`, data, {
            headers: { 'Content-Type': 'application/json' },
        })
    }
}