<template>
  <div class="custom-container">
    <h1 class ="my-12 text-lg font-bold">404 not found</h1>
    <p>ページが見つかりませんでした。</p>
    <router-link :to="{ name: 'Home' }" class="text-blue-500 underline my-10">ホームに戻る</router-link>
  </div>
</template>

