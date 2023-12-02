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

      <button type="submit" :disabled="isSubmitting" class="custom-submit">
        {{ buttonText }}
      </button>
    </form>
    <p class="my-3 text-center">
      退会する方は
      <router-link to="/user/delete" class="underline text-blue-500 hover:text-orange-600"
        >こちら</router-link
      >
    </p>
  </div>
</template>

<script setup>
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

// エラー処理
const handleError = (e) => {
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
  };
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .put("/api/user", userData)
      .then((res) => {
        store.dispatch("triggerPopup", { message: "ユーザー情報を変更しました。" });
        router.push("/");
      })
      .catch(handleError);
  });
});

const getUserData = () => {
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .get("/api/user")
      .then((res) => {
        name.value = res.data.name;
        email.value = res.data.email;
      })
      .catch((e) => {
        console.log(e);
      });
  });
};

onMounted(() => {
  getUserData();
});
</script>
