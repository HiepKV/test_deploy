<template>
  <div>
    <h5 class="fw-bold mb-4 text-center">まずは案件名を入力してください。</h5>

    <div class="card shadow-sm border-0 p-4 mx-auto" style="max-width: 70vh;">
      <div class="card-body">
        <label class="form-label fw-semibold">
          案件名 <span class="text-danger">必須</span>
        </label>
        <input
          type="text"
          v-model="title"
          class="form-control"
          placeholder="案件名を入力"
        />
      </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
      <router-link to="/surveys" class="btn btn-outline-primary me-3">一覧に戻る</router-link>
      <button
        class="btn btn-primary"
        :disabled="!title.trim()"
        @click="handleNext"
      >
        次へ
      </button>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useSurveyStore } from '@/store/surveyStore'
import { useRouter } from 'vue-router'

export default {
  setup() {
    const title = ref('')
    const store = useSurveyStore()
    const router = useRouter()

    const handleNext = () => {
      if (!title.value.trim()) return
      store.setSurveyTitle(title.value)
      router.push('/surveys/create/step2') 
    }

    return { title, handleNext }
  }
}
</script>
