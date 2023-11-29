<template>
  <div
    class="custom-container"
  >
    <h1 class="mb-8 text-2xl sm:text-3xl font-bold">ログインしました</h1>

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
