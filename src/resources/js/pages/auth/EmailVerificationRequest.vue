<template>
  <div class="custom-container">
    <h1 class="custom-header">アカウント作成</h1>
    <form @submit.prevent="sendVerificationMail" class="custom-form">
      <p class="text-gray-500">メールによる本人確認を行います。</p>
      <p class="text-gray-500 mb-5">ご連絡が可能なメールアドレスをご入力ください。</p>
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

      <p class="my-3">
        <router-link :to="{ name: 'Terms' }" class="underline text-blue-500 hover:text-orange-600">利用規約</router-link>
        と
        <router-link :to="{ name: 'Privacy' }" class="underline text-blue-500 hover:text-orange-600">プライバシーポリシー</router-link>
        に同意いただける場合はアカウントを作成してください。
      </p>

      <button type="submit" :disabled="isSubmitting" class="custom-submit">
        {{ buttonText }}
      </button>
    </form>

    <p class="my-5 text-center">
      既にアカウントをお持ちの方は
      <router-link :to="{ name: 'Login' }" class="underline text-blue-500 hover:text-orange-600">こちら</router-link>
    </p>

    <div class="my-5 w-full border-t flex flex-col items-center">
      <p class="my-4">外部サービスでログイン</p>
      <button @click="loginLine" class="line-login-link">LINEログイン</button>
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
const buttonText = computed(() => (isSubmitting.value ? "送信中..." : "同意して送信"));

const schema = object({
  email: string().required("必須項目です").email("メールアドレスの形式ではありません"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});
const { value: email } = useField("email");

const sendVerificationMail = handleSubmit(() => {
  isSubmitting.value = true;
  const userData = {
    email: email.value,
  };
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .post("/api/email/verify", userData)
      .then((res) => {
        store.dispatch("triggerPopup", { message: "メールを送信しました。", color: "green" });
        router.push("/email/verification/sent");
      })
      .catch((e) => {
        isSubmitting.value = false;
        store.dispatch("handleError", { e: e });
      });
  });
});

const loginLine = () => {
  location.href = "/line/login";
};
</script>
