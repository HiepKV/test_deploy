import { ROUTE_PAGE } from "@/constants/routes";

export const aboutPageConfig = {
  [ROUTE_PAGE.COMMON.ABOUT]: {
    title: 'About Us',
    meta: {
      description: 'Learn more about our company',
      keywords: 'about, company, vuejs',
    },
    layout: 'default',
    requiresAuth: false,
  }
};