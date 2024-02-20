<template>
  <div class="custom-container">
    <h1 class="custom-header">パスワードリセット</h1>
    <form @submit.prevent="submitForm" class="custom-form">
      <div class="custom-form-field">
        <label for="password">パスワード</label>
        <input
          v-model="password"
          id="password"
          type="password"
          placeholder="最低6文字必要です"
          autocomplete="new-password"
          required
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.password }}</p>
      </div>

      <div class="custom-form-field">
        <label for="password_confirmation">もう一度パスワードを入力してください</label>
        <input
          v-model="password_confirmation"
          id="password_confirmation"
          type="password"
          autocomplete="new-password"
          required
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.password_confirmation }}</p>
      </div>

      <button type="submit" :disabled="isSubmitting" class="custom-submit">{{ buttonText }}</button>
    </form>
    <div class="mt-3">
      アカウントを新規作成する方は
      <router-link :to="{ name: 'EmailVerificationRequest' }" class="underline text-blue-500 hover:text-orange-600">こちら</router-link>
    </div>
    <div class="my-3">
      ログインする方は
      <router-link :to="{ name: 'Login' }" class="underline text-blue-500 hover:text-orange-600">こちら</router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useField, useForm } from "vee-validate";
import { object, string, ref as yupRef } from "yup";

const store = useStore();
const router = useRouter();
const isSubmitting = ref(false);
const buttonText = computed(() => (isSubmitting.value ? "送信中..." : "パスワード変更"));
const email = computed(() => router.currentRoute.value.query.email);
const token = computed(() => router.currentRoute.value.query.token);

const schema = object({
  password: string().required("パスワードを入力してください").min(6, "最低6文字必要です"),
  password_confirmation: string()
    .required("パスワードを再入力してください")
    .oneOf([yupRef("password"), null], "パスワードが一致しません"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});
const { value: password } = useField("password");
const { value: password_confirmation } = useField("password_confirmation");

const submitForm = handleSubmit(() => {
  isSubmitting.value = true;
  const resetData = {
    password: password.value,
    password_confirmation: password_confirmation.value,
    email: email.value,
    token: token.value,
  };
  axios
    .post("/api/password/reset", resetData)
    .then((res) => {
      store.dispatch("triggerPopup", {
        message: "パスワードをリセットしました。",
        color: "green",
      });
      router.push("/login");
    })
    .catch((e) => {
      isSubmitting.value = false;
      store.dispatch("handleAuthError", { error: e });
    });
});
</script>
