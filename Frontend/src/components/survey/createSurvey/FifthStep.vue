<template>
  <div class="container py-4" style="max-width: 90vh;">
    <h3 class="fw-bold mb-4">送信内容を確認してください</h3>
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="fw-bold">案件名</h5>
      <button class="btn btn-outline-primary btn-sm" @click="router.push('/surveys/create')">編集する</button>
    </div>
    <div class="confirm-box mb-4">
      <p><strong>案件名:</strong> {{ store.survey_title }}</p>
      <p><strong>説明:</strong> {{ store.description }}</p>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="fw-bold">お問い合わせ内容</h5>
      <button class="btn btn-outline-primary btn-sm" @click="router.push('/surveys/create/step2')">編集する</button>
    </div>
    <div class="confirm-box mb-4">
      <p><strong>会社名:</strong> {{ selectedCompanyId ? selectedCompanyId.company_name : '' }}</p>
      <p v-if="selectedCompanyId && selectedCompanyId.manager">
        担当者名：
        姓：{{ selectedCompanyId.manager.gender }}　
        名：{{ selectedCompanyId.manager.manager_name }} /
        せい：{{ selectedCompanyId.manager.reason }}　
        めい：{{ selectedCompanyId.manager.niece }}
      </p>
      <p>電話番号: {{ selectedCompanyId ? selectedCompanyId.phone_number : '' }}</p>
      <p>メール: {{ selectedCompanyId ? selectedCompanyId.email : '' }}</p>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="fw-bold">リスト作成</h5>
      <button class="btn btn-outline-primary btn-sm" @click="router.push('/surveys/create/step3')">編集する</button>
    </div>
    <div class="confirm-box mb-4">
      <p><strong>キーワード:</strong> {{ store.keyword }}</p>
      <p><strong>都道府県:</strong> {{ store.prefectures.join(', ') }}</p>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="fw-bold">送信設定</h5>
      <button class="btn btn-outline-primary btn-sm" @click="router.push('/surveys/create/step3')">編集する</button>
    </div>
    <div class="confirm-box mb-4">
      <p><strong>送信日:</strong> {{ store.start_date }}</p>
      <p><strong>終了日:</strong> {{ store.end_date }}</p>
      <p><strong>送信手段:</strong> {{ store.send_method }}</p>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="fw-bold">LP内容</h5>
      <button class="btn btn-outline-primary btn-sm" @click="router.push('/surveys/create/step4')">編集する</button>
    </div>
    <div class="confirm-box mb-4">
      <p><strong>見出し:</strong> {{ store.survey_title }}</p>
      <p><strong>説明文：</strong>説明文が入ります説明文が入ります説明文が入ります説明文が入ります説明文が入ります説</p>
    </div>

    <!-- Submit -->
    <div class="d-flex justify-content-center gap-5 mt-4">
      <button class="btn btn-primary" @click="submitSurvey">送信する</button>
    </div>
  </div>
</template>

<script setup>
import { useSurveyStore } from '@/store/surveyStore'
import { useRouter } from 'vue-router'
import { CompanyService } from '@/services/companyService'
import { SurveyService } from '@/services/surveyService'
import { ref, onMounted } from 'vue'

const store = useSurveyStore()
const router = useRouter()
const comId = store.company_id
const selectedCompanyId = ref(null)
console.log(store.hero_image)
function formatDate(date) {
  if (!date) return null
  const d = new Date(date)
  if (isNaN(d.getTime())) return null
  const year = d.getFullYear()
  const month = String(d.getMonth() + 1).padStart(2, '0')
  const day = String(d.getDate()).padStart(2, '0')
  return `${year}-${month}-${day}`
}

onMounted(async () => {
  if (comId) {
    const data = await CompanyService.getById(comId)
    selectedCompanyId.value = data.data
  }
})

async function submitSurvey() {
  const payload = {
    survey_title: store.survey_title || '',
    description: store.description || '',
    survey_content: store.survey_content || '',
    company_id: selectedCompanyId.value ? selectedCompanyId.value.id : null,
    user_id: store.user_id || 1,
    keyword: store.keyword || '',
    hero_image:store.hero_image,
    prefectures: Array.isArray(store.prefectures) 
      ? store.prefectures.join(',') // convert mảng -> string
      : (store.prefectures || ''),
    status: store.status || 'waiting',
    start_date: formatDate(store.start_date),
    end_date: formatDate(store.end_date),
    // response_count: store.response_count || 0
  }

  try {
  const res = await SurveyService.createSur(payload)
  console.log("API response:", res)

  const newSurveyId = res.data.original.id
  if (newSurveyId) {
    localStorage.setItem("survey_id", newSurveyId)
  }

  router.push('/laststep') 
  store.resetSurvey()
} catch (error) {
  console.error('送信失敗:', error)
  alert('送信中にエラーが発生しました。内容をご確認ください。')
}

}
</script>

<style scoped>
.confirm-box {
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 16px;
  background-color: #f1f1f1;
}
</style>
