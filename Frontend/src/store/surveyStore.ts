import { defineStore } from 'pinia'

interface SurveyState {
  survey_title: string
  description: string
  survey_content: string
  company_id: number | null
  user_id: number
  status: string
  start_date: string | null
  end_date: string | null
  response_count: number
  keyword: string | null
  prefectures: string[] | null
  send_method: string | null
  hero_image: File | null // Lưu file gốc
  favicon: File | null    // Lưu file gốc
}

const STORAGE_KEY = 'survey_draft'

export const useSurveyStore = defineStore('survey', {
  state: (): SurveyState => {
    const saved = localStorage.getItem(STORAGE_KEY)
    return saved
      ? { ...JSON.parse(saved), hero_image: null, favicon: null }
      : {
          survey_title: '',
          description: '',
          survey_content: '',
          company_id: null,
          user_id: 1,
          status: 'waiting',
          start_date: null,
          end_date: null,
          response_count: 0,
          keyword: '',
          prefectures: [],
          send_method: '',
          hero_image: null,
          favicon: null
        }
  },

  actions: {
    saveToLocalStorage() {
      // Chỉ lưu dữ liệu text (không lưu file vào localStorage)
      const { hero_image, favicon, ...rest } = this.$state
      localStorage.setItem(STORAGE_KEY, JSON.stringify(rest))
    },

    setHeroImage(file: File) {
      this.hero_image = file
    },

    setFavicon(file: File) {
      this.favicon = file
    },

    setSurveyTitle(title: string) {
      this.survey_title = title
    },
    setDescription(desc: string) {
      this.description = desc
    },
    setSurveyContent(content: string) {
      this.survey_content = content
    },
    setCompanyId(id: number | null) {
      this.company_id = id
    },
    setUserId(id: number) {
      this.user_id = id
    },
    setStatus(status: string) {
      this.status = status
    },
    setStartDate(date: string | null) {
      this.start_date = date
    },
    setEndDate(date: string | null) {
      this.end_date = date
    },
    setResponseCount(count: number) {
      this.response_count = count
    },
    setKeyword(val: string) {
      this.keyword = val
    },
    setPrefectures(list: string[]) {
      this.prefectures = list
    },
    setSendMethod(method: string) {
      this.send_method = method
    },

    resetSurvey() {
      this.$reset()
      localStorage.removeItem(STORAGE_KEY)
    }
  }
})
