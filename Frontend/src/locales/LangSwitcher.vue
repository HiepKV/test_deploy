<template>
  <div class="lang-switcher">
    <button
      v-for="lang in langs"
      :key="lang.code"
      @click="locale = lang.code"
      :class="{ active: locale === lang.code }"
      class="lang-btn"
      :title="lang.name"
    >
      <img :src="lang.flag" :alt="lang.code" />
    </button>
  </div>
</template>

<script setup lang="ts">
import { useI18n } from 'vue-i18n'
import { onMounted, watch } from 'vue'

  const { locale } = useI18n()

  const langs = [
    { code: 'ja', flag: new URL('../assets/japan.png', import.meta.url).href, name: '日本語' },
    { code: 'en', flag: new URL('../assets/united-states.png', import.meta.url).href, name: 'English' },
  ]

  onMounted(() => {
    const savedLang = localStorage.getItem('app-lang')
    if (savedLang) {
      locale.value = savedLang
    }
  })

  watch(locale, (val) => {
    localStorage.setItem('app-lang', val)
  })

</script>

<style scoped>
.lang-switcher {
  display: flex;
  gap: 8px;
  align-items: center;
}

.lang-btn {
  background: transparent;
  border: none;
  padding: 0;
  cursor: pointer;
  opacity: 0.3;
  transition: opacity 0.2s ease;
}

.lang-btn.active {
  opacity: 1;
}

.lang-btn img {
  width: 24px;
  height: 24px;
  object-fit: cover;
  border-radius: 4px;
}
</style>
