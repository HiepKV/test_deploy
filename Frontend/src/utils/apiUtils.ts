// utils/apiUtils.ts
export const extractErrorMessage = (error: any) => {
  return error?.response?.data?.message || error.message || 'An unknown error occurred';
};

export const paginateResponse = <T>(data: T[], page: number, pageSize: number): T[] => {
  const start = (page - 1) * pageSize;
  return data.slice(start, start + pageSize);
};
