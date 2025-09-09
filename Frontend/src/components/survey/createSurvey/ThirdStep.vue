<template>
  <div class="container" style="max-width: 90vh;">
    <h5 class="fw-bold mb-4">リストを作成してください</h5>
    <div class="card p-4 mb-2">
        <div class="mb-3">
            <label class="form-label">キーワード</label>
            <input type="text" class="form-control" placeholder="キーワードを入力してください"
                v-model="keyword" />
        </div>
        <div class="mb-3">
            <label class="form-label">都道府県</label>
            <div class="border rounded p-3 list">
                <div class="row">
                <div class="col-3" v-for="pref in prefectureList" :key="pref">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                        :value="pref" v-model="prefectures" />
                    <label class="form-check-label">{{ pref }}</label>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
      <div class="border rounded p-3 bg-light">
        合計件数：{{ totalCount.toLocaleString() }}
      </div>
    </div>
    <div class="mb-3 card p-4 mb-3">
      <label class="form-label">送信する日時を設定してください <span class="text-danger">必須</span></label>
      <input type="datetime-local" class="form-control w-50" v-model="start_date" />
      <p style="font-size: small;">※前の送信対応の全てが完了してから送信開始となるため、開始時間が遅れてしまう可能性がございます。</p>
    </div>
    <div class="mb-3 card p-4 mb-3">
      <label class="form-label">時を設定してください <span class="text-danger">必須</span></label>
      <input type="datetime-local" class="form-control w-50" v-model="end_date" />
      <p style="font-size: small;">※前の送信対応の全てが完了してから送信開始となるため、開始時間が遅れてしまう可能性がございます。</p>
    </div>
    <div class="mb-3 card p-4 ">
      <label class="form-label">送信する手段を選択してください <span class="text-danger">必須</span></label>
      <div class="form-check">
        <input class="form-check-input" type="radio" value="メール" v-model="send_method" />
        <label class="form-check-label">メールで送信</label>
      </div>
    </div>
    <div class="d-flex justify-content-center gap-5 mt-4">
      <button class="btn btn-outline-primary" @click="goBack">前に戻る</button>
      <button class="btn btn-primary" @click="handleNext">次へ</button>
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useSurveyStore } from '@/store/surveyStore'

export default {
  setup() {
    const router = useRouter()
    const store = useSurveyStore()

    const keyword = ref(store.keyword)
    const prefectures = ref([...store.prefectures])
    const start_date = ref(store.start_date)
    const end_date = ref(store.end_date)
    const send_method = ref(store.send_method)

    const prefectureList = [
      '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県',
      '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県',
      '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県',
      '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県',
      '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県',
      '鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県',
      '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
      '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'
    ]

    const totalCount = computed(() => {
      return prefectures.value.length * 500
    })

    const handleNext = () => {
      if (!start_date.value || !send_method.value) {
        alert('必須項目を入力してください')
        return
      }
      store.setKeyword(keyword.value)
      store.setPrefectures(prefectures.value)
      store.setStartDate(start_date.value)
      store.setSendMethod(send_method.value)
      store.setEndDate(end_date.value)
      store.setResponseCount(totalCount)
      router.push('/surveys/create/step4')
    }

    const goBack = () => {
      router.push('/surveys/create/step2')
    }

    return {
      keyword,
      prefectures,
      end_date,
      start_date: start_date,
      send_method,
      prefectureList,
      totalCount,
      handleNext,
      goBack
    }
  }
}
</script>
<style lang="css" scoped>
.list{
    background-color: rgb(236, 236, 236);
}
</style>
