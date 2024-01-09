<template>
  <div class="custom-container">
    <h1 class="custom-header">パスワード再設定</h1>
    <p class="my-6">※ご登録のメールアドレスをご入力ください。</p>

    <form @submit.prevent="submitForm" class="custom-form">
      <div class="custom-form-field">
        <label for="email">メールアドレス</label>
        <input
          v-model="email"
          id="email"
          type="email"
          autocomplete="email"
          required
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.email }}</p>
      </div>
      <button type="submit" :disabled="isSubmitting" class="custom-submit">{{ buttonText }}</button>
    </form>
    <div class="mt-3">
      アカウントの新規作成は
      <router-link to="/registration" class="underline text-blue-500 hover:text-orange-600">こちら</router-link>
    </div>
    <div class="my-3">
      ログインは
      <router-link to="/login" class="underline text-blue-500 hover:text-orange-600">こちら</router-link>
    </div>
  </div>
</template>

<script setup>
import handleError from "../../modules/HandleError.js";
import { ref, computed } from "vue";
import { useField, useForm } from "vee-validate";
import { object, string, ref as yupRef } from "yup";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const router = useRouter();
const store = useStore();
const isSubmitting = ref(false);
const buttonText = computed(() => (isSubmitting.value ? "送信中..." : "送信"));
const schema = object({
  email: string()
    .required("メールアドレスを入力してください")
    .email("メールアドレスの形式ではありません"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});
const { value: email } = useField("email");

const submitForm = handleSubmit(() => {
  isSubmitting.value = true;
  axios
    .post("/api/password/forgot", { email: email.value })
    .then((res) => {
      store.dispatch("triggerPopup", { message: "メールを送信しました。", color: "green" });
      router.push("/");
    })
    .catch((e) => {
      isSubmitting.value = false;
      handleError(e);
    });
});
</script>
