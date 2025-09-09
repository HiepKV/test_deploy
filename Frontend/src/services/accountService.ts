import { AccountRepository } from "../repositories/accountRepository";

export const AccountService = {
  async getAccounts(search: string = "", page: number = 1) {
    const response = await AccountRepository.get(search, page);
    return {
      data: response.data.data || [],
      totalPages: response.data.last_page || 1,
    };
  },
  async createAcc(data: any){
    return await AccountRepository.post(data);
  }
};
