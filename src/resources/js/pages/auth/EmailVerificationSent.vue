<template>
  <div class="custom-container">
    <h1 class="custom-header my-5">メールを送信しました</h1>
    <CheckCircleOutlineIcon class="w-24 h-24 text-purple-500" />
    <p class="text-red-500 m-5">登録はまだ完了していません。</p>
    <ul class="text-gray-500 m-5">
      <li class="m-2">メールに記載されたリンクから、登録手続きを完了してください。</li>
      <li class="m-2">認証メールの有効期限は1時間です。</li>
      <li class="m-2">新しい認証メールを送信すると、以前のリンクは無効になります。</li>
    </ul>
    <router-link :to="{ name: 'Home' }" class="text-blue-500 underline my-10">ホームに戻る</router-link>
  </div>
</template>

<script setup>
import CheckCircleOutlineIcon from "../../components/icons/CheckCircleOutlineIcon.vue";
</script>
