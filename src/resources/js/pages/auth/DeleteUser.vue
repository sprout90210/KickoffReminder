<template>
  <div class="custom-container">
    <h1 class="custom-header">退会</h1>
    <form @submit.prevent="deleteUser" class="custom-form">
      <p>以下の注意事項をご確認して頂き、同意した上でパスワードを入力、退会するをクリックしてください。</p>
      <p class="text-gray-500 my-3">※外部認証で作成されたアカウントはパスワード入力をせずに退会できます。</p>
      <ol class="list-decimal text-red-600 m-5">
        <li class="my-1">
          アカウント削除後に、ユーザーに紐づく全てのデータが削除されます。削除後に、復元することはできません。
        </li>
        <li class="my-1">
          再度サービスを利用される際は、新しくユーザを作成する必要があります。以前のデータを移行することはできません。
        </li>
      </ol>
      <div v-if="!isLineUser" class="custom-form-field">
        <label for="password">パスワード</label>
        <input
          id="password"
          v-model="password"
          type="password"
          placeholder="外部ログインの場合は不要です"
          autocomplete="current-password"
          class="custom-input"
        />
      </div>
      <button type="submit" :disabled="isSubmitting" class="custom-submit">{{ buttonText }}</button>
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
const isLineUser = computed(() => store.state.auth.isLineUser);
const buttonText = computed(() => (isSubmitting.value ? "送信中..." : "退会する"));

const deleteUser = () => {
  isSubmitting.value = true;
  axios
    .delete("/api/user", { data: { password: password.value } })
    .then((res) => {
      store.dispatch("userStatusUpdate", {
        isLoggedIn: false,
        isLineUser: false,
        receiveReminder: false,
        remindTime: false,
      });
      store.dispatch("triggerPopup", { message: "退会しました。", color: "green" });
      router.push("/");
    })
    .catch((e) => {
      isSubmitting.value = false;
      store.dispatch("handleAuthError", { error: e });
    });
};
</script>
