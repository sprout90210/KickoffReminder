<template>
  <div class="custom-container">
    <h1 class="custom-header">ユーザー登録</h1>
    <form @submit.prevent="submitForm" class="custom-form">
      <div class="custom-form-field">
        <label for="name">ユーザーネーム</label>
        <input
          v-model="name"
          id="name"
          type="text"
          autocomplete="username"
          required="required"
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.name }}</p>
      </div>

      <div class="custom-form-field">
        <label for="email">メールアドレス</label>
        <input
          v-model="email"
          id="email"
          type="email"
          autocomplete="email"
          required="required"
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
          placeholder="6文字以上の英数字が必要です"
          autocomplete="new-password"
          required="required"
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
          required="required"
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.password_confirmation }}</p>
      </div>

      <p class="mt-3">
        <router-link to="/terms" class="underline text-blue-500 hover:text-orange-600">
          利用規約
        </router-link>
        と
        <router-link to="/privacy" class="underline text-blue-500 hover:text-orange-600">
          プライバシーポリシー
        </router-link>
        に同意いただける場合はアカウントを作成してください。
      </p>

      <button type="submit" :disabled="isSubmitting" class="custom-submit">
        {{ buttonText }}
      </button>
    </form>

    <p class="my-3 text-center">
      既にアカウントをお持ちの場合は
      <router-link to="/login" class="underline text-blue-500 hover:text-orange-600">こちら</router-link>
    </p>

    <div class="mt-3 w-full border-t flex flex-col items-center">
      <p class="my-4">外部サービスでログイン</p>
      <button @click="loginLine" class="line-login-btn">LINEログイン</button>
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
const buttonText = computed(() => (isSubmitting.value ? "送信中..." : "登録"));

const schema = object({
  name: string().required("必須項目です"),
  email: string().required("必須項目です").email("メールアドレスの形式ではありません"),
  password: string().required("必須項目です").min(6, "最低6文字必要です"),
  password_confirmation: string()
    .required("パスワードを再入力してください")
    .oneOf([yupRef("password"), null], "パスワードが一致しません"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});

const { value: name } = useField("name");
const { value: email } = useField("email");
const { value: password } = useField("password");
const { value: password_confirmation } = useField("password_confirmation");

// エラー処理
const handleError = (e) => {
  password.value = "";
  password_confirmation.value = "";
  isSubmitting.value = false;
  let message;
  if (e.response.status === 422) {
    const errors = e.response.data.errors;
    const errorKey = Object.keys(errors)[0];
    message = errors[errorKey][0];
  } else {
    message = "フォーム送信時にエラーが発生しました。後でもう一度お試しください。";
  }
  store.dispatch("triggerPopup", { message });
};

// フォーム送信
const submitForm = handleSubmit(() => {
  isSubmitting.value = true;
  const userData = {
    name: name.value,
    email: email.value,
    password: password.value,
    password_confirmation: password_confirmation.value,
  };
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .post("/api/register", userData)
      .then((res) => {
        store.commit("setLoggedIn", true);
        store.dispatch("triggerPopup", { message: "アカウントを作成しました。" });
        router.push("/");
      })
      .catch(handleError);
  });
});

const loginLine = () => {
  location.href = "/line/login";
};
</script>
