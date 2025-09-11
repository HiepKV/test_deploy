import axios from "axios";
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export const AuthRepository = {
    async login(credentials: { username: string; password: string }) {
        return await axios.post(`${API_BASE_URL}/auth/login`, credentials, {
            headers: { 'Content-Type': 'application/json' },
        });
    },
    async logout() {
        return await axios.post(`${API_BASE_URL}/auth/logout`);
    }
}