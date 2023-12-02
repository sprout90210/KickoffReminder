<template>
  <div class="custom-container">
    <h1 class="custom-header">退会</h1>
    <div class="sm:w-96 px-6">
      <p class="my-3">
        以下の注意事項をご確認して頂き、同意した上でパスワードを入力、退会するをクリックしてください。
      </p>
      <p class="text-gray-500 my-3">
        ※外部認証で作成されたアカウントはパスワード入力不要です。
      </p>
      <ol class="list-decimal text-red-600 m-5">
        <li class="my-1">
          アカウント削除後に、ユーザに紐づく全てのデータが削除されます。削除後に、復元することはできません。
        </li>
        <li class="my-1">
          再度サービスを利用される際は、新しくユーザを作成する必要があります。以前のデータを移行することはできません。
        </li>
      </ol>
    </div>
    <form @submit.prevent="deleteUser" class="custom-form">
      <div class="custom-form-field">
        <label for="password">パスワード</label>
        <input
          v-model="password"
          id="password"
          type="password"
          placeholder="外部ログインの場合は不要です"
          autocomplete="current-password"
          class="custom-input"
        />
      </div>
      <button type="submit" class="custom-submit" :disabled="isSubmitting">
        {{ buttonText }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

const router = useRouter();
const store = useStore();
const password = ref("");
const isSubmitting = ref(false);
const buttonText = computed(() => (isSubmitting.value ? "送信中..." : "退会"));

// エラー処理
const handleError = (e) => {
  isSubmitting.value = false;
  const message =
    e.response.status === 403
      ? "パスワードに誤りがあります。"
      : "フォーム送信時にエラーが発生しました。後でもう一度お試しください。";
  store.dispatch("triggerPopup", { message });
};

// フォーム送信
const deleteUser = () => {
  isSubmitting.value = true;
  axios.get("/sanctum/csrf-cookie").then((res) => {
    axios
      .delete("/api/user", { data: { password: password.value } })
      .then((res) => {
        store.dispatch("logout");
        store.dispatch("triggerPopup", { message: "退会しました。" });
        router.push("/");
      })
      .catch(handleError);
  });
};
</script>
