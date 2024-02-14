<template>
  <div class="flex flex-col items-center justify-center h-36">
    <div class="loader ease-linear rounded-full border-2 border-t-2 border-gray-200 h-6 w-6"></div>
    <div class="mt-8 text-sm">データ取得中...</div>
  </div>
</template>

<style scoped>
.loader {
  border-top-color: #3498db;
  animation: spin 0.6s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
