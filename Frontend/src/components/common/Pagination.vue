<template>
    <div class="pagination">
      <!-- Nút Previous -->
      <button
        class="page-btn prev-btn"
        :disabled="currentPage === 1"
        @click="changePage(currentPage - 1)"
      >
        &lt;
      </button>
  
      <!-- Các nút số trang -->
      <button
        v-for="page in totalPages"
        :key="page"
        class="page-btn"
        :class="{ active: page === currentPage }"
        @click="changePage(page)"
      >
        {{ page }}
      </button>
  
      <!-- Nút Next -->
      <button
        class="page-btn next-btn"
        
        :disabled="currentPage === totalPages"
        @click="changePage(currentPage + 1)"
      >
        &gt;
      </button>
    </div>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from "vue";
  
  // Nhận props từ parent
  const props = defineProps({
  totalPages: {
    type: Number,
    required: true,
  },
  currentPage: {
    type: Number,
    required: true,
  },
});
  
  // Emit sự kiện thay đổi trang
  const emit = defineEmits(["update:currentPage"]);
  
  const changePage = (page) => {
    if (page >= 1 && page <= props.totalPages) {
      emit("update:currentPage", page);
    }
  };
  </script>
  
  <style scoped>
  /* Kiểu dáng pagination */
  .pagination {
    display: flex;
    align-items: center;
    justify-content: start;
    gap: 5px;
  }
  
  .page-btn {
    padding: 8px 12px;
    border: 1px solid #ccc;
    background-color: #fff;
    border-radius: 4px;
    cursor: pointer;
    color: #333;
  }
  
  .page-btn:hover {
    background-color: #f4f4f4;
  }
  
  .page-btn.active {
    background-color: #007bff;
    color: #fff;
    font-weight: bold;
  }
  
  .page-btn:disabled {
    background-color: #e9ecef;
    color: #ccc;
    cursor: not-allowed;
  }
  </style>
  