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
          autocomplete="new-password"
          required="required"
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.password }}</p>
      </div>
      <p class="mt-2">
        <input type="checkbox" name="remember" v-model="remember" />
        <span> ログインしたままにする </span>
      </p>
      <button
        type="submit"
        class="my-5 py-3 w-full block rounded bg-fuchsia-500 hover:bg-fuchsia-600 text-white duration-200 shadow-lg shadow-gray-600/40"
      >
        ログイン
      </button>
    </form>
    <div class="mt-3">
      パスワードを忘れの方は
      <router-link
        to="/password/forgot"
        class="underline text-blue-500 hover:text-orange-600"
        >こちら</router-link
      >
    </div>
    <div class="my-3">
      アカウントを新規作成する方は
      <router-link
        to="/registration"
        class="underline text-blue-500 hover:text-orange-600"
        >こちら</router-link
      >
    </div>
    <div class="my-8 py-4 w-full border-t flex flex-col items-center">
      <p class="my-4">外部サービスでログイン</p>
      <button
        @click="loginLine"
        class="line-login-btn"
      >
        LINEログイン
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useField, useForm } from "vee-validate";
import { object, string, ref as yupRef } from "yup";
import { useStore } from "vuex";
import { useRoute, useRouter } from "vue-router";

const store = useStore();
const router = useRouter();
const remember = ref(false);
// const isLoggedIn = computed(() => store.state.isLoggedIn);

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
  const credentials = {
    email: email.value,
    password: password.value,
    remember: remember.value,
  };
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .post("/api/login", credentials)
      .then((res) => {
        store.commit("setLoggedIn", true);
        store.dispatch("triggerPopup", { message: "ログインに成功しました。" });
        router.push("/");
      })
      .catch((e) => {
        password.value = "";
        if (e.response.status === 401 || e.response.status === 422) {
          store.dispatch("triggerPopup", {
            message: "メールアドレスもしくはパスワードに誤りがあります。",
          });
        } else {
          store.dispatch("triggerPopup", {
            message: "フォーム送信時にエラーが発生しました。後でもう一度お試しください。",
          });
        }
      });
  });
});

const loginLine = () => {
  location.href = "/line/login";
};
</script>
