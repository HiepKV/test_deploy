<template>
  <div class="container py-4">
    <div class="d-flex justify-content-center align-items-center mb-5">
      <template v-for="(item, index) in steps" :key="index">
        <!-- Step -->
        <div class="d-flex flex-column align-items-center">
          <div class="step-circle" :class="{ active: step >= index + 1 }">
            <i :class="item.icon"></i>
          </div>
          <div class="step-label" :class="{ active: step >= index + 1 }">
            {{ item.label }}
          </div>
        </div>

        <!-- Line -->
        <div v-if="index < steps.length - 1" class="step-line"></div>
      </template>
    </div>

    <router-view @next="goNext" />
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  setup() {
    const step = ref(1)
    const steps = [
      { label: '案件名', icon: 'bi bi-pencil-fill' },
      { label: 'お問い合わせ内容', icon: 'bi bi-chat-text-fill' },
      { label: 'リスト作成', icon: 'bi bi-list-check' },
      { label: 'LP設定', icon: 'bi bi-gear-fill' },
      { label: '送信内容の確認', icon: 'bi bi-send-fill' }
    ]

    const goNext = () => {
      if (step.value < steps.length) step.value++
    }

    return { step, steps, goNext }
  }
}
</script>

<style scoped>
.step-circle {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background-color: #e9ecef;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  color: #6c757d;
  transition: all 0.3s ease;
}
.step-circle.active {
  background-color: #0d6efd;
  color: #fff;
}

.step-label {
  margin-top: 10px;
  font-size: 14px;
  color: #6c757d;
  text-align: center;
}
.step-label.active {
  color: #0d6efd;
  font-weight: 600;
}

.step-line {
  flex: 1;
  height: 2px;
  background-color: #dee2e6;
  margin: 0 15px;
  max-width: 50px;
}
</style>
