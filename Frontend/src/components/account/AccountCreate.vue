<template>
  <div class="container mt-4">
    <h2 class="mb-4">{{ t('account.title') }}</h2>
    <div class="card p-4">
      <form @submit.prevent="submitForm">
        <!-- ID -->
        <div class="mb-3">
          <label class="form-label">ID <span class="text-danger">{{ t('account.required') }}</span></label>
          <input
            type="text"
            class="form-control"
            v-model="account.id"
            :placeholder="t('account.placId')"
            required
          />
        </div>

        <!-- Username -->
        <div class="mb-3">
          <label class="form-label">{{ t('account.username') }}<span class="text-danger">{{ t('account.required') }}</span></label>
          <input
            type="text"
            class="form-control"
            v-model="account.username"
            :placeholder="t('account.placUser')"
            required
          />
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label class="form-label">{{ t('account.pass') }}<span class="text-danger">{{ t('account.placPass') }}</span></label>
          <input
            type="password"
            class="form-control"
            v-model="account.password"
            :placeholder="t('account.placPass')"
            required
            minlength="6"
          />
        </div>

        <!-- Memo (nullable) -->
        <div class="mb-3">
          <label class="form-label">{{ t('account.memo') }}</label>
          <textarea
            class="form-control"
            v-model="account.memo"
            :placeholder="t('account.placMemo')"
            rows="3"
          ></textarea>
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-center">
          <button type="button" class="btn btn-outline-primary me-3" @click="goBack">
            {{ t('account.return') }}
          </button>
          <button type="submit" class="btn btn-primary">{{ t('account.submit') }}</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { AccountService } from "@/services/accountService";
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const router = useRouter();

const account = ref({
  id: "",
  username: "",
  password: "",
  memo: "",
});

const submitForm = async () => {
  // Simple validation
  if (!account.value.id || !account.value.username || !account.value.password) {
    alert("必須フィールドをすべて入力してください。");
    return;
  }
  if (account.value.password.length < 6) {
    alert("パスワードは6文字以上で入力してください。");
    return;
  }

  try {
    const requestData = {
      id: account.value.id,
      username: account.value.username,
      password: account.value.password,
      memo: account.value.memo.trim() === "" ? null : account.value.memo.trim(),
    };

    const response = await AccountService.createAcc(requestData);
    alert("アカウントが登録されました！");
    router.push("/accounts");
  } catch (error) {
    console.error("登録エラー:", error);
    if (error.response && error.response.data && error.response.data.message) {
      alert(error.response.data.message);
    } else {
      alert("エラーが発生しました。もう一度お試しください。");
    }
  }
};

const goBack = () => {
  router.push("/accounts");
};
</script>

<style scoped>
.container {
  max-width: 600px;
}
.card {
  background: #fff;
  border-radius: 8px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
.form-label {
  font-weight: bold;
}
.btn-primary {
  background-color: #007bff;
  border: none;
}
.btn-outline-primary {
  border: 1px solid #007bff;
}
.text-danger {
  font-size: 14px;
  font-weight: bold;
}
</style>
