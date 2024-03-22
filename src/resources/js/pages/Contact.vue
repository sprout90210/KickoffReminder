<template>
  <div class="custom-container">
    <h1 class="custom-header">お問い合わせ</h1>
    <p class="my-2">※お問合せ、ご要望はこちらにお願いします。</p>
    <form @submit.prevent="submitForm" class="custom-form">
      <div class="custom-form-field">
        <label for="password">お名前</label>
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
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.email }}</p>
      </div>

      <div class="flex flex-col my-1 sm:my-3 w-full">
        <label for="contact">お問い合わせ内容</label>
        <textarea
          v-model="contact"
          id="contact"
          required
          class="rounded text-xs sm:text-sm h-56"
        >
        </textarea>
        <p class="text-red-700">{{ errors.contact }}</p>
      </div>

      <button type="submit" :disabled="isSubmitting" class="custom-submit">{{ buttonText }}</button>
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
  contact: string().required("必須項目です"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});
const { value: name } = useField("name");
const { value: email } = useField("email");
const { value: contact } = useField("contact");

const submitForm = handleSubmit(() => {
  isSubmitting.value = true;
  const formData = {
    name: name.value,
    email: email.value,
    contact: contact.value,
  };
  axios
    .post("/api/contact", formData)
    .then((res) => {
      store.dispatch("triggerPopup", { message: "お問い合わせを送信しました。", color: "green" });
      router.push("/");
    })
    .catch((e) => {
      isSubmitting.value = false;
      store.dispatch("handleError", { e: e });
    });
});
</script>
