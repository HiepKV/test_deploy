<template>
    <div class="container mt-4">
        <h2 class="mb-4">{{ t('company.title') }}</h2>
        <div class="card p-4">
            <form @submit.prevent="submitForm">
                <!-- 会社名 -->
                <div class="mb-3">
                    <label class="form-label">{{ t('company.name') }} <span class="text-danger">{{ t('company.required') }}</span></label>
                    <input type="text" class="form-control" v-model="company.company_name" :placeholder="t('company.placCom')"
                        required />
                </div>

                <!-- 担当者名 -->
                <div class="mb-3">
                    <label class="form-label">{{ t('company.manager_detail') }} <span class="text-danger">{{ t('company.required') }}</span></label>
                    <div class="row">
                        <div class="col-md-6">
                           
                            <input type="text" class="form-control mb-3" v-model="company.gender" placeholder="性"
                                required />
                            <input type="text" class="form-control mb-3" v-model="company.reason" placeholder="せい"
                                required />     
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control mb-3" v-model="company.manager_name" placeholder=" 名"
                                required />
                            <input type="text" class="form-control mb-3" v-model="company.niece" placeholder="めい"
                                required />
                        </div>
                    </div>
                </div>

                <!-- 電話番号 -->
                <div class="mb-3">
                    <label class="form-label">{{ t('company.phone') }} <span class="text-danger">{{ t('company.required') }}</span></label>
                    <input type="tel" class="form-control" v-model="company.phone_number" :placeholder="t('company.placPhone')"
                        required />
                </div>

                <!-- メールアドレス -->
                <div class="mb-3">
                    <label class="form-label">{{ t('company.email') }} <span class="text-danger">{{ t('company.required') }}</span></label>
                    <input type="email" class="form-control" v-model="company.email" :placeholder="t('company.placMail')"
                        required />
                </div>

                <!-- ボタン -->
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-primary me-3" @click="goBack">{{ t('account.return') }}</button>
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
import { useI18n } from "vue-i18n";

const { t } = useI18n();
// import { log } from "console";

const router = useRouter();

// Khởi tạo dữ liệu công ty
const company = ref({
    company_name: "",
    manager_name: "",
    reason: "",
    niece: "",
    gender: "", // Mặc định là Nam
    phone_number: "",
    email: "",
});
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

if (!csrfToken) {
    console.error("⚠️ CSRF token không tồn tại. Hãy kiểm tra lại meta tag.");
}

// Xử lý gửi form
const submitForm = async () => {


    if (!company.value.company_name || !company.value.phone_number || !company.value.email) {
        alert("⚠️ すべての必須フィールドを入力してください！"); // Hiển thị cảnh báo nếu thiếu dữ liệu
        return;
    }
    try {
        
        // Chuẩn bị dữ liệu đúng format cho backend
        const requestData = {
            company_name: company.value.company_name,
            phone_number: company.value.phone_number,
            email: company.value.email,
            company_created_by: "Admin",
            manager_name: company.value.manager_name,
            gender: company.value.gender,
            reason: company.value.reason,
            niece: company.value.niece,
        };


        const response = await axios.post("http://127.0.0.1:8000/api/companies", requestData, {
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        console.debug("Company Created:", response.data);
        alert("会社が登録されました！");
        router.push("/companies");
    } catch (error) {
        console.error("エラーが発生しました:", error);
        if (error.response) {
            console.error("Chi tiết lỗi:", error.response.data);
            alert(error.response.data.message || "エラーが発生しました。もう一度試してください。");
        } else {
            alert("サーバーエラーが発生しました。もう一度試してください。");
        }
    }
};

// Quay lại danh sách công ty
const goBack = () => {
    router.push("/companies");
};
</script>

<style scoped>
.container {
    max-width: 800px;
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
