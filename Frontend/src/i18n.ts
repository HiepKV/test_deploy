import { createI18n } from "vue-i18n";
import * as messages from "./locales"

const savedLocale = localStorage.getItem("locale") || "ja";

const i18n = createI18n({
  legacy: false,
  locale: savedLocale,
  fallbackLocale: "en",
  messages
});

export default i18n;
