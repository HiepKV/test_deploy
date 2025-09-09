<template>
  <div class="container py-4" style="max-width: 100vh; left: 20vh;">
    <h5 class="fw-bold mb-3">お問い合わせ内容を入力してください。</h5>

    <div class="card shadow-sm p-4">
      <!-- Chọn công ty -->
      <div class="mb-3">
        <label class="form-label">会社名 <span class="text-danger">必須</span></label>
        <select v-model="selectedCompanyId" class="form-select" @change="handleCompanyChange">
          <option value="">-- 会社を選択 --</option>
          <option v-for="c in companies" :key="c.id" :value="c.id">
            {{ c.company_name }}
          </option>
        </select>
      </div>
      <div v-if="selectedCompany" class="mb-3">
        <div class="row mb-2 row-gap-2">
            <label class="form-label">担当者名</label>
            <div class="col-md-6">
                <input type="text" class="form-control" v-model="selectedCompany.manager.manager_name" disabled>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" v-model="selectedCompany.manager.gender" disabled>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" v-model="selectedCompany.manager.reason" disabled>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" v-model="selectedCompany.manager.niece" disabled>
            </div>
          </div>
        <div class="mb-2">
          <label class="form-label">メールアドレス</label>
          <input type="email" class="form-control" v-model="selectedCompany.email" disabled>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">件名 <span class="text-danger">必須</span></label>
        <input type="text" class="form-control" v-model="description" placeholder="件名を入力">
      </div>

      <div class="mb-3">
        <label class="form-label">お問い合わせ内容 <span class="text-danger">必須</span></label>
        <textarea class="form-control" rows="4" v-model="surveyContent" placeholder="お問い合わせを入力"></textarea>
      </div>
    </div>
    <div class="d-flex gap-5 mt-2 justify-content-center">
      <button class="btn btn-outline-secondary" @click="goBack">戻る</button>
      <button class="btn btn-primary" @click="goNext">次へ</button>
    </div>
</div>
</template>

<script setup lang="ts">
import { onMounted, ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useSurveyStore } from '@/store/surveyStore'
import { CompanyService } from '@/services/companyService'

const router = useRouter()
const store = useSurveyStore()

const companies = ref<any[]>([])
const selectedCompanyId = ref<string | number>('')

const description = ref(store.description)
const surveyContent = ref(store.survey_content)

// Lấy thông tin công ty được chọn
const selectedCompany = computed(() =>
  companies.value.find(c => c.id === Number(selectedCompanyId.value))
)

onMounted(async () => {
  const { data } = await CompanyService.getAll()
  companies.value = data
  if (store.company_id) {
    selectedCompanyId.value = store.company_id
  }
})

function handleCompanyChange() {
  if (selectedCompany.value) {
    store.setCompanyId(selectedCompany.value.id)
  }
}

function goNext() {
  if (!selectedCompanyId.value) {
    alert('会社名を選択してください')
    return
  }
  if (!description.value.trim()) {
    alert('件名を入力してください')
    return
  }
  if (!surveyContent.value.trim()) {
    alert('お問い合わせ内容を入力してください')
    return
  }

  store.setCompanyId(Number(selectedCompanyId.value))
  store.setDescription(description.value)
  store.setSurveyContent(surveyContent.value)

  router.push('/surveys/create/step3')
}

function goBack() {
  router.push('/surveys/create')
}
</script>
<style scoped>
.btn{
    min-width: 100px;
}
</style>