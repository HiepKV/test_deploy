import { defineStore } from "pinia";

export const useFileStore = defineStore("fileStore", {
  state: () => ({
    file: localStorage.getItem("fileBase64") || null as string | null, // khởi tạo từ localStorage
  }),
  actions: {
    async setFile(file: File) {
      const base64 = await this.convertToBase64(file);
      this.file = base64;
      localStorage.setItem("fileBase64", base64); // lưu vào localStorage
    },
    clearFile() {
      this.file = null;
      localStorage.removeItem("fileBase64"); // xoá khỏi localStorage
    },
    convertToBase64(file: File): Promise<string> {
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result as string);
        reader.onerror = (error) => reject(error);
      });
    },
    base64ToFile(base64: string, fileName: string): File {
      const arr = base64.split(",");
      const match = arr[0].match(/:(.*?);/);
      const mime = match ? match[1] : "application/octet-stream"; // fallback

      const bstr = atob(arr[1]);
      let n = bstr.length;
      const u8arr = new Uint8Array(n);
      while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
      }
      return new File([u8arr], fileName, { type: mime });
    },
  },
});
