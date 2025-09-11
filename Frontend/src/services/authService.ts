import { AuthRepository } from "@/repositories/authRepository";

export const AuthService = {
    async login(credentials: { username: string; password: string }) {
        return await AuthRepository.login(credentials);
    },
    async logout() {
        return await AuthRepository.logout();
    },
}