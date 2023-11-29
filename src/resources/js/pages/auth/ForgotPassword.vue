<template>
  <div
    class="custom-container"
  >
    <h1 class="custom-header">パスワード再設定</h1>
    <p class="my-4">※ご登録のメールアドレスをご入力ください。</p>

    <form @submit.prevent="submitForm" class="custom-form">
      <div class="custom-form-field">
        <label for="email">メールアドレス</label>
        <input
          v-model="email"
          id="email"
          type="email"
          autocomplete="email"
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.email }}</p>
      </div>
      <button
        type="submit"
        class="my-5 py-3 w-full rounded bg-fuchsia-500 hover:bg-fuchsia-600 text-white duration-200 shadow-lg shadow-gray-600/40"
      >
        メールを送信
      </button>
    </form>
    <div class="mt-3">
      アカウントの新規作成は
      <router-link to="/register" class="underline text-blue-500 hover:text-orange-600"
        >こちら</router-link
      >
    </div>
    <div class="my-3">
      ログインは
      <router-link to="/login" class="underline text-blue-500 hover:text-orange-600"
        >こちら</router-link
      >
    </div>
    {{message}}
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useField, useForm } from "vee-validate";
import { object, string, ref as yupRef } from "yup";

const schema = object({
  email: string()
    .required("メールアドレスを入力してください")
    .email("メールアドレスの形式ではありません"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});

const { value: email } = useField("email");
const message = ref("");

const submitForm = handleSubmit(() => {
  message.value = "しばらくお待ちください...";
  const userData = {
    email: email.value,
  };
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .post("/api/password/forgot", userData)
      .then((res) => {
        message.value = "メールを送信しました。";
      })
      .catch((e) => {
        if (e.response.status === 422) {
          message.value = 
            "メールアドレスまたはパスワードをお確かめください。";
        } else {
          console.log(e.response.data.message);
          message.value = 
            "申し訳ありませんが、フォーム送信時にエラーが発生しました。後でもう一度お試しください。";
        }
      });
  });
});
</script>
