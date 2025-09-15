import api from "./api";

export const AccountRepository = {
  get(search: string = "", page: number = 1) {
    const params: Record<string, any> = { page };
    if (search) {
      params.search = search;
    }
    return api.get("/accounts", { params });
  },
  post(data: any) {
    return api.post("/accounts", data);
  }
};
