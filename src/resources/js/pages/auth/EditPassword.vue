<template>
  <div class="custom-container">
    <h1 class="custom-header">パスワード変更</h1>
    <form @submit.prevent="submitForm" class="custom-form">
      <div class="custom-form-field">
        <label for="current_password">現在のパスワード</label>
        <input
          v-model="current_password"
          id="current_password"
          type="password"
          autocomplete="current-password"
          required
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.current_password }}</p>
      </div>

      <div class="custom-form-field">
        <label for="new_password">新しいパスワード</label>
        <input
          v-model="new_password"
          id="new_password"
          type="password"
          placeholder="最低6文字必要です"
          autocomplete="new-password"
          required
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.new_password }}</p>
      </div>

      <div class="custom-form-field">
        <label for="new_password_confirmation">もう一度パスワードを入力してください</label>
        <input
          v-model="new_password_confirmation"
          id="new_password_confirmation"
          type="password"
          autocomplete="new-password"
          required
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.new_password_confirmation }}</p>
      </div>

      <button type="submit" :disabled="isSubmitting" class="custom-submit">{{ buttonText }}</button>
    </form>
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

const schema = object({
  current_password: string().required("現在のパスワードを入力してください").min(6, "最低6文字必要です"),
  new_password: string().required("新しいパスワードを入力してください").min(6, "最低6文字必要です"),
  new_password_confirmation: string()
    .required("新しいパスワードを再入力してください")
    .oneOf([yupRef("new_password"), null], "パスワードが一致しません"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});
const { value: current_password } = useField("current_password");
const { value: new_password } = useField("new_password");
const { value: new_password_confirmation } = useField("new_password_confirmation");

const submitForm = handleSubmit(() => {
  isSubmitting.value = true;
  const userData = {
    current_password: current_password.value,
    new_password: new_password.value,
    new_password_confirmation: new_password_confirmation.value,
  };
  axios
    .put("/api/password", userData)
    .then((res) => {
      store.dispatch("triggerPopup", { message: "パスワードを変更しました。", color: "green" });
      router.push("/");
    })
    .catch((e) => {
      isSubmitting.value = false;
      store.dispatch("handleAuthError", { error: e });
    });
});
</script>
