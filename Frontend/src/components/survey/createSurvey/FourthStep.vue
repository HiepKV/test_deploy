<template>
  <div class="container py-4" style="position: relative; left: 25vh;">
    <h3 class="fw-bold mb-2">LPの内容を設定してください</h3>
    <div class="card p-4" style="max-width: 100vh;">

      <!-- Hero Image -->
      <div class="mb-4">
        <label class="form-label fw-semibold">
          ヒーロー画像 <span class="text-danger">必須</span>
        </label>
        <div class="upload-box" @dragover.prevent @drop.prevent="onDrop('hero', $event)">
          <div v-if="heroPreview" class="mb-2 text-center">
            <img :src="heroPreview" class="img-fluid" style="max-height: 200px;" />
          </div>
          <input
            type="file"
            accept="image/*"
            class="form-control mb-2"
            @change="onSelect('hero', $event)"
          />
          <small class="text-muted">ここにファイルをドロップ</small>
        </div>
      </div>

      <!-- Favicon -->
      <div class="mb-4">
        <label class="form-label fw-semibold">
          ファビコン <span class="text-danger">必須</span>
        </label>
        <div class="upload-box" @dragover.prevent @drop.prevent="onDrop('favicon', $event)">
          <div v-if="faviconPreview" class="mb-2 text-center">
            <img :src="faviconPreview" class="img-fluid" style="max-height: 100px;" />
          </div>
          <input
            type="file"
            accept="image/*"
            class="form-control mb-2"
            @change="onSelect('favicon', $event)"
          />
          <small class="text-muted">ここにファイルをドロップ</small>
        </div>
      </div>

      <!-- Title -->
      <div class="mb-3">
        <label class="form-label">見出し <span class="text-danger">必須</span></label>
        <input
          type="text"
          class="form-control"
          v-model="survey_title"
          placeholder="見出し文を入力"
        />
      </div>

      <!-- Description -->
      <div class="mb-3">
        <label class="form-label">説明文 <span class="text-danger">必須</span></label>
        <textarea
          class="form-control"
          rows="4"
          v-model="description"
          placeholder="説明文を入力"
        ></textarea>
      </div>
    </div>

    <!-- Buttons -->
    <div class="button-gp">
      <button class="btn btn-outline-primary dd" @click="preview" style="position: relative; left: 30%;">
        プレビュー
      </button>
      <div class="d-flex justify-content-center gap-5 mt-4" style="position: relative; right: 20vh;">
        <button class="btn btn-outline-secondary" @click="goBack">戻る</button>
        <button class="btn btn-primary" @click="goNext">次へ</button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useSurveyStore } from '@/store/surveyStore'

const router = useRouter()
const survey = useSurveyStore()

const localHeroPreview = ref<string | null>(null)
const localFaviconPreview = ref<string | null>(null)

const heroPreview = computed<string | null>(() => {
  if (localHeroPreview.value) return localHeroPreview.value
  if (survey.hero_image && typeof survey.hero_image === 'string') {
    return (survey.hero_image as string)?.startsWith('http')
      ? survey.hero_image
      : `${import.meta.env.VITE_API_BASE_URL}/storage/${survey.hero_image}`
  }
  return null
})

const faviconPreview = computed<string | null>(() => {
  if (localFaviconPreview.value) return localFaviconPreview.value
  if (survey.favicon && typeof survey.favicon === 'string') {
    return (survey.favicon as string)?.startsWith('http')
      ? survey.favicon
      : `${import.meta.env.VITE_API_BASE_URL}/storage/${survey.favicon}`
  }
  return null
})


const description = ref(survey.description)
const survey_title = ref(survey.survey_title)

async function onSelect(type: 'hero' | 'favicon', e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0]
  if (!file) return
  const url = URL.createObjectURL(file)

  if (type === 'hero') {
    localHeroPreview.value = url
    await survey.setHeroImage(file)
  } else {
    localFaviconPreview.value = url
    await survey.setFavicon(file)
  }
}

async function onDrop(type: 'hero' | 'favicon', e: DragEvent) {
  const file = e.dataTransfer?.files?.[0]
  if (!file) return
  const url = URL.createObjectURL(file)

  if (type === 'hero') {
    localHeroPreview.value = url
    await survey.setHeroImage(file)
  } else {
    localFaviconPreview.value = url
    await survey.setFavicon(file)
  }
}

function goBack() {
  router.push('/surveys/create/step3')
}

function goNext() {
  if (!survey.hero_image || !survey.favicon || !survey.survey_title || !survey.description) {
    alert('全ての必須項目を入力してください。')
    return
  }
  router.push('/surveys/create/step5')
}

function preview() {
  router.push('/preview')
}
</script>

<style scoped>
.upload-box {
  border: 2px dashed #ccc;
  border-radius: 8px;
  padding: 1.5rem;
  text-align: center;
  transition: border-color 0.2s ease;
  background: #fafafa;
  max-width: 50vh;
}
.upload-box:hover {
  border-color: #0d6efd;
}
.button-gp {
  position: relative;
  top: 10px;
}
.button-gp .btn {
  min-width: 15vh;
  border-radius: 20px;
}
.button-gp .dd {
  border-radius: 5px;
}
</style>
