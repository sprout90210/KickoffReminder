<template>
  <div class="flex flex-col items-center text-sm h-36">
    <p class="my-10 text-center text-gray-500">データが見つかりませんでした。</p>
    <router-link :to="{ name: 'Home' }" class="text-blue-500 mb-5 underline">ホームに戻る</router-link>
  </div>
</template>