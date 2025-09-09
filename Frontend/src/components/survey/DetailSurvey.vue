<template>
  <div class="container py-4" v-if="survey">
    <section class="mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">案件情報</h5>
        <span
          class="status-badge"
          :class="{
            'status-waiting': survey.status === 'waiting',
            'status-inprogress': survey.status === 'inprogress',
            'status-completed': survey.status === 'completed'
          }"
        >
          {{ formatStatus(survey.status) }}
        </span>
      </div>

      <div class="card p-4">
        <div class="mb-3">
          <p class="mb-0">
            <strong>案件名：</strong>
            {{ survey.survey_title }}
          </p>
        </div>

        <div class="mb-3">
          <strong>回答数：</strong>
          <span>{{ survey.response_count?.toLocaleString() }} 件</span>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <strong>開始日時：</strong>
            <span>{{ formatDate(survey.start_date) || '-' }}</span>
          </div>
          <div class="col-md-6">
            <strong>終了日時：</strong>
            <span>{{ formatDate(survey.end_date) || '-' }}</span>
          </div>
        </div>
            <table class="table">
            <thead class="table-light">
                <tr>
                <td>リスト件数</td>
                <td>送信完了件数</td>
                <td>反響件数</td>
                <td>商談件数</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ itemCount }}</td>          
                    <td>{{ survey.sent_count }}</td>
                    <td>{{ survey.response_count }}</td>
                    <td>{{ survey.intents_count }}</td>
                </tr>
            </tbody>
            </table>
        <div class="row">
          <div class="col-md-6 mb-2 mb-md-0">
            <strong>案件作成者：</strong>
            <span>{{ survey.company?.manager?.manager_name }}</span>
          </div>
          <div class="col-md-6">
            <strong>案件作成日時：</strong>
            <span>{{ formatDate(survey.created_at) || '-' }}</span>
          </div>
        </div>
      </div>
    </section>

    <section>
      <h5 class="fw-bold mb-3">お問い合わせ内容</h5>
      <div class="card p-4">
        <table class="table table-borderless align-middle detail-table mb-4">
          <tbody>
            <tr>
              <th>会社名</th>
              <td>{{ survey.company?.company_name }}</td>
            </tr>
            <tr>
              <th>担当者名</th>
              <td>{{ survey.company?.manager?.manager_name }}</td>
            </tr>
            <tr>
              <th>電話番号</th>
              <td>{{ survey.company?.phone_number }}</td>
            </tr>
            <tr>
              <th>メールアドレス</th>
              <td>{{ survey.company?.email }}</td>
            </tr>
            <tr>
              <th>件名</th>
              <td>{{ survey.survey_title }}</td>
            </tr>
            <tr class="inquiry-row">
              <th>お問い合わせ内容</th>
              <td>{{ survey.survey_content }}</td>
            </tr>
          </tbody>
        </table>

        <div class="text-center">
          <router-link to="/surveys" class="btn btn-outline-primary">
            一覧に戻る
          </router-link>
        </div>
      </div>
    </section>
  </div>

  <div v-else class="text-center py-5">Loading...</div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { SurveyService } from '@/services/surveyService'

const route = useRoute()
const survey = ref(null)

const fetchData = async () => {
  try {
    const {data} = await SurveyService.getById(Number(route.params.id))
    survey.value = data
  } catch (error) {
    console.error('Error fetching survey data:', error)
  }
}

const formatDate = (dateStr) => {
  if (!dateStr) return ''
  const normalized = dateStr.replace(' ', 'T')
  const d = new Date(normalized)
  return (
    d.toLocaleDateString('ja-JP') +
    ' ' +
    d.toLocaleTimeString('ja-JP', { hour: '2-digit', minute: '2-digit' })
  )
}
const itemCount = localStorage.getItem('itemCount') || 0
const formatStatus = (status) => {
  if (status === 'waiting') return '待機中'
  if (status === 'inprogress') return '進行中'
  if (status === 'completed') return '完了'
  return status
}

onMounted(fetchData)
</script>

<style scoped>
.card {
  border-radius: 8px;
  background-color: #fff;
}

.status-badge {
  display: inline-block;
  padding: 6px 14px;
  font-size: 14px;
  font-weight: 600;
  border-radius: 20px;
  text-align: center;
  min-width: 90px;
}

.status-waiting {
  background-color: #ffe5e5;
  color: #d9534f;
}

.status-inprogress {
  background-color: #e6f3ff;
  color: #0d6efd;
}

.status-completed {
  background-color: #f1f1f1;
  color: #6c757d;
}

.detail-table th,
.detail-table td {
  border-bottom: 1px solid #dee2e6;
  padding: 10px 12px;
  vertical-align: top;
}

.detail-table th {
  background-color: #f8f9fa;
  font-weight: 600;
  width: 25%;
}

.detail-table td {
  background-color: #fff;
  white-space: pre-wrap;
}

.detail-table .inquiry-row td {
  min-height: 100px;
  line-height: 1.6;
}
</style>
