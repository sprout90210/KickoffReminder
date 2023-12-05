<template>
  <div class="custom-container">
    <h1 class="custom-header">お問い合わせ</h1>
    <form @submit.prevent="submitForm" class="custom-form">
      <div class="custom-form-field">
        <label for="password">ネーム</label>
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

      <div class="flex flex-col w-full h-72">
        <label for="inquiry">お問い合わせ内容</label>
        <textarea
          v-model="inquiry"
          id="inquiry"
          required
          class="rounded text-xs sm:text-sm h-56"
        >
        </textarea>
        <p class="text-red-700">{{ errors.inquiry }}</p>
      </div>

      <button type="submit" :disabled="isSubmitting" class="custom-submit">
        {{ buttonText }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useField, useForm } from "vee-validate";
import { object, string, ref as yupRef } from "yup";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();
const isSubmitting = ref(false);
const buttonText = computed(() => (isSubmitting.value ? "送信中..." : "送信"));

const schema = object({
  name: string().required("必須項目です"),
  email: string().required("必須項目です").email("メールアドレスの形式ではありません"),
  inquiry: string().required("必須項目です"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});

const { value: name } = useField("name");
const { value: email } = useField("email");
const { value: inquiry } = useField("inquiry");

// エラー処理
const handleError = (e) => {
  console.log(e)
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
  const formData = {
    name: name.value,
    email: email.value,
    inquiry: inquiry.value,
  };
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .post("/api/contact", formData)
      .then((res) => {
        store.dispatch("triggerPopup", { message: "お問い合わせを送信しました。" });
        router.push("/");
      })
      .catch(handleError);
  });
});
</script>
