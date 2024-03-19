<template>
  <div class="custom-container">
    <h1 class="custom-header">ログイン</h1>
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

      <div class="custom-form-field">
        <label for="password">パスワード</label>
        <input
          v-model="password"
          id="password"
          type="password"
          autocomplete="current-password"
          required
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.password }}</p>
      </div>

      <p class="my-3 flex items-center">
        <input v-model="remember" id="remember" type="checkbox" />
        <label for="remember" class="ml-1">ログインしたままにする</label>
      </p>

      <button type="submit" :disabled="isSubmitting" class="custom-submit">{{ buttonText }}</button>
    </form>

    <p class="mt-3">
      パスワードをお忘れの方は
      <router-link :to="{ name: 'ForgotPassword' }" class="underline text-blue-500 hover:text-orange-600">こちら</router-link>
    </p>
    <p class="my-3">
      アカウントを新規作成する方は
      <router-link :to="{ name: 'EmailVerificationRequest' }" class="underline text-blue-500 hover:text-orange-600">こちら</router-link>
    </p>

    <div class="my-5 w-full border-t flex flex-col items-center">
      <p class="my-4">外部サービスでログイン</p>
      <button @click="loginLine" class="line-login-link">LINEログイン</button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useField, useForm } from "vee-validate";
import { object, string, ref as yupRef } from "yup";
import { useStore } from "vuex";
import { useRoute, useRouter } from "vue-router";

const store = useStore();
const router = useRouter();
const isSubmitting = ref(false);
const remember = ref(false);
const buttonText = computed(() => (isSubmitting.value ? "送信中..." : "ログイン"));

const schema = object({
  email: string().required("必須項目です").email("メールアドレスの形式ではありません"),
  password: string().required("必須項目です").min(6, "最低6文字必要です"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});
const { value: email } = useField("email");
const { value: password } = useField("password");

const submitForm = handleSubmit(() => {
  isSubmitting.value = true;
  const credentials = {
    email: email.value,
    password: password.value,
    remember: remember.value,
  };
  axios.get("/sanctum/csrf-cookie").then(() => {
    axios
      .post("/api/login", credentials)
      .then((res) => {
        store.dispatch("userStatusUpdate", {
          isLoggedIn: true,
          isLineUser: false,
          remindTime: res.data.remindTime,
          receiveReminder: res.data.receiveReminder,
        });
        store.dispatch("triggerPopup", { message: "ログインしました。", color: "green" });
        router.push("/");
      })
      .catch((e) => {
        password.value = "";
        isSubmitting.value = false;
        store.dispatch("handleAuthError", { error: e });
      });
  });
});

const loginLine = () => {
  location.href = "/line/login"
};
</script>
