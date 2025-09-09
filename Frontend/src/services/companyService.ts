import { CompanyRepository } from "@/repositories/companyRepository";

export const CompanyService =
{
    async getAll(search: string = "", page: number = 1) {
        const response = await CompanyRepository.getAll(search, page);
        return {
          data: response.data.data || [],
          totalPages: response.data.last_page || 1,
        };
      },
      async getById(id: number){
        return await CompanyRepository.getById(id);
      }
}