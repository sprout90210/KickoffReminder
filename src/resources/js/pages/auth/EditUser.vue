<template>
  <div class="custom-container">
    <h1 class="custom-header">ユーザー情報変更</h1>
    <form @submit.prevent="submitForm" class="custom-form">
      <div class="custom-form-field">
        <label for="password">ユーザーネーム</label>
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
    <p class="my-3 text-center">
      退会する方は
      <router-link to="/user/delete" class="underline text-blue-500 hover:text-orange-600">こちら</router-link>
    </p>
  </div>
</template>

<script setup>
import handleError from "../../modules/HandleError.js";
import { ref, computed, onMounted } from "vue";
import { useField, useForm } from "vee-validate";
import { object, string, ref as yupRef } from "yup";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();
const isSubmitting = ref(false);
const buttonText = computed(() => (isSubmitting.value ? "送信中..." : "変更"));

const schema = object({
  name: string().required("必須項目です"),
  email: string().required("必須項目です").email("メールアドレスの形式ではありません"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});

const { value: name } = useField("name");
const { value: email } = useField("email");

const submitForm = handleSubmit(() => {
  isSubmitting.value = true;
  const userData = {
    name: name.value,
    email: email.value,
  };
  axios
    .put("/api/user", userData)
    .then((res) => {
      store.dispatch("triggerPopup", { message: "ユーザー情報を変更しました。", color: "green" });
      router.push("/");
    })
    .catch((e) => {
      isSubmitting.value = false;
      handleError(e);
    });
});

const getUserData = () => {
  axios
    .get("/api/user")
    .then((res) => {
      name.value = res.data.name;
      email.value = res.data.email;
    })
    .catch((e) => {
      handleError(e);
    });
};

onMounted(() => {
  getUserData();
});
</script>