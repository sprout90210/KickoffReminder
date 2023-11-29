<template>
  <div class="custom-container">
    <h1 class="custom-header">パスワード変更</h1>
    <form @submit.prevent="submitForm" class="custom-form">
      <div class="custom-form-field">
        <label for="password">パスワード</label>
        <input
          v-model="password"
          id="password"
          type="password"
          placeholder="8文字以上の英数字が必要です"
          autocomplete="new-password"
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
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.password_confirmation }}</p>
      </div>

      <button
        type="submit"
        class="my-5 py-3 w-32 rounded bg-fuchsia-500 hover:bg-fuchsia-600 text-white duration-200 shadow-lg shadow-gray-600/40"
      >
        変更
      </button>
    </form>
    <div class="text-red-500">
      {{ message }}
    </div>
      
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useField, useForm } from "vee-validate";
import { object, string, ref as yupRef } from "yup";

const schema = object({
  password: string().required("パスワードを入力してください").min(8, "最低8文字必要です"),
  password_confirmation: string()
    .required("パスワードを再入力してください")
    .oneOf([yupRef("password"), null], "パスワードが一致しません"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});

const { value: password } = useField("password");
const { value: password_confirmation } = useField("password_confirmation");
const message = ref();

const submitForm = handleSubmit(() => {
  message.value = "しばらくお待ちください...";
  const userData = {
    password: password.value,
    password_confirmation: password_confirmation.value,
  };
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .post("/api/password/reset", userData)
      .then((res) => {
        if (res.data.isLoggedIn) {
          location.href = "/login";
        }
      })
      .catch((e) => {
        if (e.response.status === 422) {
          const errors = e.response.data.errors;
          const errorKey = Object.keys(errors)[0];
          message.value = errors[errorKey][0];
        } else {
          console.log(e);
          message.value =
            "申し訳ありませんが、フォーム送信時にエラーが発生しました。後でもう一度お試しください。";
        }
      });
  });
});


</script>
