import { en, ja } from "@/locales"
import { createI18n } from "vue-i18n"

const messages = {
  en,
  ja,
}

const i18n = createI18n({
  locale: "en", // Default language
  fallbackLocale: "en",
  messages,
})

export default i18n
