<template>
  <div class="custom-container">
    <h1 class="custom-header">アカウント作成</h1>
    <p class="my-3">メールアドレス: {{ email }}</p>
    <form @submit.prevent="sendVerificationMail" class="custom-form">
      <div class="custom-form-field">
        <label for="name">ユーザーネーム</label>
        <input
          v-model="name"
          id="name"
          type="text"
          autocomplete="username"
          required
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.name }}</p>
      </div>

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
        <label for="password_confirmation">パスワードを再入力してください</label>
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

      <button type="submit" :disabled="isSubmitting" class="custom-submit">
        {{ buttonText }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useStore } from "vuex";
import { useRoute, useRouter } from "vue-router";
import { useField, useForm } from "vee-validate";
import { object, string, ref as yupRef } from "yup";

const store = useStore();
const route = useRoute();
const router = useRouter();
const email = ref(route.query.email);
const token = ref(route.query.token);
const isSubmitting = ref(false);
const buttonText = computed(() => (isSubmitting.value ? "登録中..." : "新規登録"));

const schema = object({
  name: string().required("必須項目です"),
  password: string().required("必須項目です").min(6, "最低6文字必要です"),
  password_confirmation: string()
    .required("パスワードを再入力してください")
    .oneOf([yupRef("password"), null], "パスワードが一致しません"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});
const { value: name } = useField("name");
const { value: password } = useField("password");
const { value: password_confirmation } = useField("password_confirmation");

const sendVerificationMail = handleSubmit(() => {
  isSubmitting.value = true;
  const userData = {
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
    token: token.value,
  };
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .post("/api/register", userData)
      .then((res) => {
        store.dispatch("userStatusUpdate", {
          isLoggedIn: res.data.isLoggedIn,
          isLineUser: res.data.isLineUser,
          remindTime: res.data.remindTime,
          receiveReminder: res.data.receiveReminder,
        });
        store.dispatch("triggerPopup", { message: "アカウントを作成しました。", color: "green" });
        router.push("/");
      })
      .catch((e) => {
        isSubmitting.value = false;
        store.dispatch("handleAuthError", { error: e });
      });
  });
});
</script>
