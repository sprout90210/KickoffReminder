<template>
  <div class="bg-gray-50">
    <h2 class="home-section-header text-gray-700">試合通知の受け取り方</h2>
    <div class="text-sm lg:text-lg flex flex-col lg:flex-row justify-center items-center">
      <Procedure img="https://kickoffreminder-bucket.s3.ap-northeast-1.amazonaws.com/images/procedure.png" class="lg:mt-5">新規登録またはログイン</Procedure>
      <ResponsiveArrowIcon />
      <Procedure img="https://kickoffreminder-bucket.s3.ap-northeast-1.amazonaws.com/images/procedure2.png" class="lg:mt-5">好きなチームを探す</Procedure>
      <ResponsiveArrowIcon />
      <Procedure img="https://kickoffreminder-bucket.s3.ap-northeast-1.amazonaws.com/images/procedure3.png" class="lg:mt-5">お気に入り登録を押す</Procedure>
      <ResponsiveArrowIcon />
      <div class="flex flex-col items-center justify-center">
        <p class="h-5 text-sm font-bold text-gray-500">※ LINEログインの方だけ</p>
        <Procedure img="https://kickoffreminder-bucket.s3.ap-northeast-1.amazonaws.com/images/line_qr.png">公式LINEを友達追加</Procedure>
      </div>
    </div>
    <p class="text-center mt-7 mb-2 text-gray-500 text-sm font-bold">※ 通知時間は通知リストから設定できます。</p>
    <p class="text-center mb-7 text-gray-500 text-sm font-bold">※ LINEで通知を受け取りたい方は、LINEログインしてください。</p>
  </div>
</template>

<script setup>
import Procedure from "./Procedure.vue";
import ResponsiveArrowIcon from "../icons/ResponsiveArrowIcon.vue";
</script>