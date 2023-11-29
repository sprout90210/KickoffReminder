<template>
  <div
    class="custom-container"
  >
    <h1 class="custom-header">退会</h1>
    <div class="w-80">
      <p class="my-3">
        以下の注意事項をご確認して頂き、同意した上でパスワードを入力、退会するをクリックしてください。
      </p>
      <p class="text-gray-500 my-3">
        ※外部認証で作成されたアカウントはパスワード入力不要です。
      </p>
      <ol class="list-decimal text-red-600 p-3">
        <li class="my-1">
          アカウント削除後に、ユーザに紐づく全てのデータが削除されます。削除後に、復元することはできません。
        </li>
        <li class="my-1">
          再度サービスを利用される際は、新しくユーザを作成する必要があります。以前のデータを移行することはできません。
        </li>
      </ol>
    </div>
    <form @submit.prevent="submitForm" class="custom-form">
      <div class="custom-form-field">
        <label for="password">パスワード</label>
        <input
          v-model="password"
          id="password"
          type="password"
          placeholder="最低8文字必要です"
          autocomplete="new-password"
          class="custom-input"
        />
        <p class="text-red-700">{{ errors.password }}</p>
      </div>

      <button
        type="submit"
        class="my-5 py-3 w-full rounded bg-fuchsia-500 hover:bg-fuchsia-600 text-white duration-200 shadow-lg shadow-gray-600/40"
      >
        退会する
      </button>
      <div class="my-3">
        パスワードを忘れの方は
        <router-link to="/mypage" class="underline text-blue-500 hover:text-orange-600"
          >戻る</router-link
        >
      </div>
    </form>
    <div class="text-red-500">
      {{ message }}
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useField, useForm } from "vee-validate";
import { object, string, ref as yupRef } from "yup";

const schema = object({
  password: string().required("パスワードを入力してください").min(8, "最低8文字必要です"),
});

const { errors, handleSubmit } = useForm({
  validationSchema: schema,
});

const { value: password } = useField("password");
const message = ref();

const submitForm = handleSubmit(() => {
  message.value = "しばらくお待ちください...";
  const userData = {
    password: password.value,
  };
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .delete("/api/user", userData)
      .then((res) => {
        if (res.data.isLoggedIn) {
          localStorage.setItem("isLoggedIn", "false");
          location.href = "/";
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
