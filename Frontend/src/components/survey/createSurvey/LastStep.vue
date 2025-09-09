<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="card shadow-sm p-4 text-center" style="max-width: 500px; border-radius: 8px;">
      <div class="mb-3">
        <i class="bi bi-check-circle-fill text-primary" style="font-size: 2.5rem;"></i>
      </div>
      <h5 class="mb-2 fw-bold">送信の設定が完了しました。</h5>
      <p class="text-muted mb-4" style="font-size: 0.9rem;">
        設定された日時より、送信を開始致します。
      </p>
      <button class="btn btn-outline-primary px-4" @click="returnHome">
        一覧画面に戻る
      </button>
    </div>
  </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router';
import { ListService } from '@/services/listService';
import { useFileStore } from '@/store/fileStore';

const store = useFileStore()
const router = useRouter()
const savedSurveyId = Number(localStorage.getItem("survey_id"))

const returnHome = async () => {
  const fileBase64 = localStorage.getItem("fileBase64");
  if (!fileBase64) {
    alert("送信するファイルはまだありません");
    return;
  }
  const file = store.base64ToFile(fileBase64, "upload.xlsx");

  try {
    await ListService.importToSendMail(savedSurveyId, file);
    alert("メールは正常に送信されました");
    localStorage.removeItem("survey_id")
    localStorage.removeItem("fileBase64")
    router.push('/surveys')
  } catch (error) {
    console.error(error);
    alert("メール送信エラー");
  }
}
</script>


