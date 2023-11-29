<template>
  <div
    class="custom-container"
  >
    <h1 class="custom-header">メールアドレス変更</h1>

    <div class="text-red-500 my-3">
      {{ message }}
    </div>

  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useRoute } from "vue-router";

const message = ref();
const isLoggedIn = ref(true);

onMounted(() => {
  localStorage.setItem("isLoggedIn", "true");
});
</script>
