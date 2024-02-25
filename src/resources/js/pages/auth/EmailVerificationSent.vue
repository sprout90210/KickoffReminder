<template>
  <div class="custom-container">
    <h1 class="custom-header my-5">メールを送信しました</h1>
    <CheckCircleOutlineIcon class="w-24 h-24 text-purple-500" />
    <p class="text-red-500 m-5">認証メールの有効期限は1時間です。</p>
    <p class="text-gray-500 m-5">受信したメールに記載されたURLにアクセスし、本登録を完了させてください。</p>
    <router-link :to="{ name: 'Home' }" class="text-blue-500 underline my-10">ホームに戻る</router-link>
  </div>
</template>

<script setup>
import CheckCircleOutlineIcon from "../../components/icons/CheckCircleOutlineIcon.vue";
</script>
