import api from "./api";

export const CompanyRepository = {
  async getAll(search: string = "", page: number = 1) {
    const params: Record<string, any> = { page };
    if (search) {
      params.search = search;
    }
    return await api.get("/companies", { params });
  },

  async getById(id: number) {
    return await api.get(`/companies/${id}`);
  }
};
