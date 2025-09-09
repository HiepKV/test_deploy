<template>
  <div class=" row">
    <div class="col-md-11  mx-auto" style="padding: 0;">
      <div class="list-header mb-3" style="border-bottom: 1px solid #ccc;padding: 15px 0 20px 0;">
        <div>
          <h1 class="page-title">{{ t('company.list') }}</h1>
          <input type="text" class="search-bar" :placeholder="t('company.plachoder')" v-model="searchQuery" />
        </div>
        <button class="btn btn-primary fw-bold" @click="goToCreatePage">+ {{ t('company.btn') }}</button>
      </div>

      <p style="color: #AFAFAF; font-size: 14px;">1~10 {{ t('company.from') }} 50 {{ t('company.items') }}</p>
      <table class="company-table">
        <thead>
          <tr>
            <th>{{ t('company.name') }}</th>
            <th>{{ t('company.manager') }}</th>
            <th>{{ t('company.phone') }}</th>
            <th>{{ t('company.email') }}</th>
            <th>{{ t('company.created_at') }}</th>
            <th>{{ t('company.updated_at') }}</th>
            <th>{{ t('company.created_by') }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="row in tableData" :key="row.id">

            <td>{{ row.company_name }}</td>
            <td>{{ row.manager.manager_name }}</td>
            <td>{{ row.phone_number }}</td>
            <td>{{ row.email }}</td>
            <td>{{ formatDate(row.created_at) }}</td>
            <td>{{ formatDate(row.updated_at) }}</td>
            <td>{{ row.company_created_by }}</td>
          </tr>
        </tbody>
      </table>
      <!--Pagination -->
      <Pagination :totalPages="totalPages" v-model:currentPage="currentPage" />

    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import Pagination from "../common/Pagination.vue";
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
  return new Intl.DateTimeFormat("en-US", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
  }).format(date);
};
const goToCreatePage = () => {
  router.push("/companies/create"); // Chuyển trang đúng cách
};
// get data
const fetchData = async (page, search = "") => {
  try {
    const response = await axios.get(`http://127.0.0.1:8000/api/companies`, {
      params: { page, search }, // send keyword to api
    });
    
    tableData.value = response.data.data;
    totalPages.value = response.data.last_page || 1;
  } catch (error) {
    console.error("Lỗi khi lấy dữ liệu công ty:", error);
  }
};

// Call api when change page
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

/* .company-table th, */
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