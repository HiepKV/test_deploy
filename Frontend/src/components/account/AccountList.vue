<template>
  <div class="row">
    <div class="col-md-11 mx-auto" style="padding: 0;">
      <div class="list-header mb-3" style="border-bottom: 1px solid #ccc; padding: 15px 0 20px 0;">
        <div>
          <h1 class="page-title">{{ t('account.list') }}</h1>
          <input type="text" class="search-bar" :placeholder="t('account.placUser')" v-model="searchQuery" />
        </div>
        <button class="btn btn-primary fw-bold" @click="goToCreatePage">+ {{ t('account.btn') }}</button>
      </div>

      <p style="color: #AFAFAF; font-size: 14px;">
        {{ tableData.length }} {{ t('account.from') }} {{ totalPages }} {{ t('account.items') }}
      </p>

      <table class="company-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>{{ t('account.username') }}</th>
            <th>{{ t('account.memo') }}</th>
            <th>{{ t('account.created_at') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in tableData" :key="row.id">
            <td>{{ row.id }}</td>
            <td>{{ row.username }}</td>
            <td>{{ row.memo || '-' }}</td>
            <td>{{ formatDate(row.created_at) }}</td>
          </tr>
        </tbody>
      </table>

      <Pagination :totalPages="totalPages" v-model:currentPage="currentPage" />
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import { useRouter } from "vue-router";
import Pagination from "../common/Pagination.vue";
import { AccountService } from "../../services/accountService";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const router = useRouter();
const currentPage = ref(1);
const totalPages = ref(1);
const tableData = ref([]);
const searchQuery = ref("");

const formatDate = (dateString) => {
  if (!dateString) return "";
  const date = new Date(dateString);
  return new Intl.DateTimeFormat("ja-JP", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
  }).format(date);
};

const goToCreatePage = () => {
  router.push("/accounts/create");
};

const fetchData = async (page, search = "") => {
  try {
    const result = await AccountService.getAccounts(search, page);
    tableData.value = result.data;
    totalPages.value = result.totalPages;
  } catch (error) {
    console.error("Lỗi khi lấy dữ liệu account:", error);
  }
};

watch(currentPage, (newPage) => {
  fetchData(newPage, searchQuery.value);
});

watch(searchQuery, (newSearch) => {
  fetchData(1, newSearch);
});

onMounted(() => {
  fetchData(currentPage.value);
});
</script>

<style scoped>
.page-title {
  font-size: 24px;
  font-weight: bold;
  color: #64707E;
  margin-bottom: 20px;
}

.search-bar {
  width: 300px;
  padding: 10px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.company-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

.company-table td {
  border: 1px solid #ddd;
  padding: 10px;
  text-align: left;
}

.company-table th {
  font-size: 16px;
  color: #64707E;
  font-weight: bold;
}

.list-header {
  display: flex;
  justify-content: space-between;
  align-items: end;
}
</style>
