<template>
  <div class="container-fluid py-4 px-5">
    <h5 class="fw-bold mb-4">{{ t('list.name') }}</h5>
    <div class="card total-box shadow-sm border-0 mb-4">
      <div class="p-3 ps-4 fw-semibold d-flex align-items-center" style="font-size: 15px;">
        {{ t('list.total') }} {{ totalRows.toLocaleString() }}
      </div>
    </div>
    <div class="mb-3">
      <input type="file" ref="fileInput" class="d-none" @change="handleFileChange" accept=".xls,.xlsx" />
      <button class="btn btn-outline-primary fw-bold me-2" @click="triggerUpload">
      <i class="bi bi-arrow-clockwise"></i> {{ t('list.upload') }}
      </button>
    </div>
    <button class="btn btn-outline-primary fw-bold" @click="downloadExcel">
     <i class="bi bi-box-arrow-down"></i> {{ t('list.download') }}
    </button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { ListService } from "@/services/listService";
import { useFileStore } from "@/store/fileStore";
import { useI18n } from "vue-i18n";

const { t } = useI18n()
const totalRows = ref(0);
const fileInput = ref(null);
const store = useFileStore()
const triggerUpload = () => {
  fileInput.value.click();
};

const handleFileChange = async (event) => {
  const file = event.target.files[0];
  if (!file) return;
  store.setFile(file);
  try {
    const res = await ListService.importList(file)
    totalRows.value = res.data.total || 0;
    localStorage.setItem('itemCount', totalRows.value.toString());
  } catch (error) {
    console.error("Upload failed", error);
  }
};
const downloadExcel = async () => {
  try {
    const res = await ListService.exportExcel();

    const blob = new Blob([res.data], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", "List_of_recipients.xlsx");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    window.URL.revokeObjectURL(url);
  } catch (err) {
    console.error("Export Excel failed", err);
  }
};

</script>

<style scoped>
.total-box {
  background-color: #f9f9f9;
  border-radius: 8px;
}
.btn{
    min-width: 300px;
    border-radius: 30px;
    border:2px solid;
}
</style>
