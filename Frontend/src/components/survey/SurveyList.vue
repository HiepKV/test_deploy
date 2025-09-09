<template>
  <div class="row">
    <div class="col-md-11 mx-auto p-0">
      <!-- Header -->
      <div class="border-bottom pb-3 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h1 class="h4 fw-bold m-0">Surveys</h1>
          <button class="btn btn-primary fw-bold" @click="goToCreatePage">
            + {{ t('survey.btn') }}
          </button>
        </div>
        <input type="text" class="form-control" style="max-width: 300px" :placeholder="t('survey.plachoder')" v-model="searchQuery" />
      </div>


      <!-- Info -->
      <p class="text-muted small mb-2">
        {{ from }}-{{ to }} {{ t('survey.from') }} {{ total }} {{ t('survey.items') }}
      </p>

      <!-- Table -->
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>{{ t('survey.name') }}</th>
              <th>{{ t('survey.status') }}</th>
              <th>{{ t('survey.company_name') }}</th>
              <th>{{ t('survey.total_list') }}</th>
              <th>{{ t('survey.response_total') }}</th>
              <th>{{ t('survey.send_date') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in tableData" :key="row.id" @click="goToDetail(row.id)" style="cursor: pointer;">
              <td>{{ row.survey_title }}</td>
              <td>
                <span class="px-2 py-1 d-inline-block fw-semibold rounded-1" :class="statusClass(row.status)"
                  style="border-bottom: 3px solid currentColor;">
                  {{ row.status }}
                </span>
              </td>
              <td>{{ row.company.company_name || '-' }}</td>
              <td>{{ row.sent_count || '-' }}</td>
              <td>
                <a v-if="row.response_count" href="#" class="text-primary">
                  {{ row.response_count }}
                </a>
                <span v-else>-</span>
              </td>
              <td>{{ formatDate(row.start_date) }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <Pagination :totalPages="totalPages" v-model:currentPage="currentPage" />
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import { useRouter } from "vue-router";
import Pagination from "../common/Pagination.vue";
import { SurveyService } from "@/services/surveyService";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const router = useRouter();

const currentPage = ref(1);
const totalPages = ref(1);
const total = ref(0);
const from = ref(0);
const to = ref(0);
const tableData = ref([]);
const searchQuery = ref("");

const formatDate = (dateString) => {
  if (!dateString) return "-";
  const date = new Date(dateString);
  return new Intl.DateTimeFormat("ja-JP", {
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
    hour: "2-digit",
    minute: "2-digit",
  }).format(date);
};

const statusClass = (status) => {
  switch (status?.toLowerCase()) {
    case "waiting":
      return "bg-danger-subtle text-danger";
    case "inprogress":
      return "bg-primary-subtle text-primary";
    case "completed":
      return "bg-secondary-subtle text-secondary";
    default:
      return "bg-light text-dark";
  }
};

const goToCreatePage = () => {
  router.push("/surveys/create");
};

const goToDetail = (id) => {
  router.push(`/surveys/${id}`);
};

const fetchData = async (page, search = "") => {
  try {
    const response = await SurveyService.getAll(search, page);
    tableData.value = response.data;
    totalPages.value = response.totalPages;
    if (response.meta) {
      total.value = response.meta.total || 0;
      from.value = response.meta.from || 0;
      to.value = response.meta.to || 0;
    } else {
      total.value = tableData.value.length;
      from.value = (page - 1) * 10 + 1;
      to.value = from.value + tableData.value.length - 1;
    }
  } catch (error) {
    console.error("Lỗi khi lấy dữ liệu survey:", error);
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
