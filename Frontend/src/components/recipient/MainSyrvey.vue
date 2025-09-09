<template>
  <div class="bao">
    <div class="main-container" v-if="recipient">
      <h5 class="fw-bold p-2 mb-3">{{ recipient.survey_title }}</h5>

      <div class="hero-wrapper mb-3">
        <img
          :src="recipient.hero_image || '../../assets/common/umi.jfif'"
          alt="Hero"
          class="hero-image"
        />
      </div>

      <p class="text-muted lh-base mb-4">{{ recipient.survey_content }}</p>

      <div class="form-card">
        <h6 class="fw-bold mb-3">お問い合わせフォーム</h6>

        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label class="form-label">名前 <span class="text-danger">必須</span></label>
            <input v-model="form.intent_name" type="text" class="custom-input" placeholder="お名前を入力してください" />
          </div>

          <div class="mb-3">
            <label class="form-label">会社名 <span class="text-danger">必須</span></label>
            <input v-model="form.company_name" type="text" class="custom-input" placeholder="会社名を入力してください" />
          </div>

          <div class="mb-3">
            <label class="form-label">メールアドレス <span class="text-danger">必須</span></label>
            <input v-model="form.email" type="email" class="custom-input" placeholder="メールアドレスを入力してください" />
          </div>

          <div class="mb-3">
            <label class="form-label">電話番号 <span class="text-danger">必須</span></label>
            <input v-model="form.phone_number" type="text" class="custom-input" placeholder="電話番号を入力してください" />
          </div>

          <div class="mb-3">
            <label class="form-label">お問い合わせ内容 <span class="text-danger">必須</span></label>
            <textarea v-model="form.response_text" class="custom-input" rows="4" placeholder="お問い合わせ内容を入力してください"></textarea>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary px-5 rounded-pill">送信する</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { SurveyService } from '@/services/surveyService';
import { IntentService } from '@/services/intentService';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const recipient = ref<any>(null);
const surveyId = ref(Number(route.params.id));
// object form
const form = ref({
  intent_name: '',
  company_name: '',
  phone_number: '',
  email: '',
  response_text: '',
  survey_id: surveyId.value,
});

const fetchData = async () => {
  try {
    const res = await SurveyService.getById(Number(route.params.id));
    recipient.value = res.data;
  } catch (error) {
    console.error('Fetch error', error);
  }
};

const submitForm = async () => {
  try {
    const data: any = { ...form.value }; 
    await IntentService.post(data);

    router.push('/formanswer/successful'); 
  } catch (error: any) {
    console.error('Submit error', error);
    if (error.response?.status === 422) {
      console.log('Validation errors:', error.response.data.errors);
    }
  }
};

onMounted(fetchData);
</script>

<style scoped>
.bao {
  background-color: #f1f1f1;
}
.main-container {
  max-width: 900px;
  margin: auto;
  padding: 20px;
  background-color: #fff;
}
.hero-wrapper {
  width: 100%;
  max-height: 400px;
  overflow: hidden;
  border-radius: 10px;
}
.hero-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.form-card {
  background: #f5f5f5;
  border-radius: 10px;
  padding: 25px;
}
.custom-input {
  width: 100%;
  padding: 8px 12px;
  border: 1px solid #000;
  border-radius: 6px;
  font-size: 15px;
}
textarea.custom-input {
  resize: vertical;
}   
</style>
