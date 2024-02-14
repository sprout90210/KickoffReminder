<template>
  <div>
    <HomeHero />
    <Directions />
    
    <div class="bg-home-2 flex flex-col items-center justify-center text-white">
      <div class="flex flex-wrap justify-center my-5 text-lg sm:text-3xl font-bold">
        <p>好きなチームを探して</p>
        <p>お気に入り登録しよう！</p>
      </div>
      <p class="text-sm font-light">※ユーザー登録が必要です。</p>
    </div>

    <h2 class="home-section-header text-white bg-gradient-to-l from-fuchsia-900 to-gray-900">リーグから探す</h2>
    <div class="flex flex-wrap justify-around lg:px-20 xl:px-40 bg-white">
      <CompetitionLink
        v-for="competition in competitions"
        :key="competition.id"
        :competition="competition"
      />
    </div>

    <h2 class="home-section-header text-white bg-gradient-to-l from-red-800 to-stone-800">注目チーム</h2>
    <div class="flex flex-wrap justify-around">
      <TeamLink
        v-for="team in featuredTeams"
        :key="team.id"
        :team="team"
      />
    </div>

    <h2 class="home-section-header text-white bg-gradient-to-l from-blue-900 to-stone-800">日本人所属チーム</h2>
    <div class="flex flex-wrap justify-around">
      <TeamLink
        v-for="team in japaneseTeams"
        :key="team.id"
        :team="team"
      />
    </div>

    <UpcomingGames />
  </div>
</template>

<script setup>
import HomeHero from "../components/home/HomeHero.vue";
import Directions from "../components/home/Directions.vue";
import CompetitionLink from "../components/home/CompetitionLink.vue";
import TeamLink from "../components/home/TeamLink.vue";
import UpcomingGames from "../components/home/UpcomingGames.vue";

const competitions = [
  { id: 2021, name: "プレミアリーグ" },
  { id: 2014, name: "ラ・リーガ" },
  { id: 2002, name: "ブンデスリーガ" },
  { id: 2019, name: "セリエA" },
  { id: 2015, name: "リーグ・アン" },
  { id: 2001, name: "UEFA CL" },
];
const featuredTeams = [
  { id: 86, name: "レアルマドリード", color: "hover:bg-stone-300" },
  { id: 81, name: "バルセロナ", color: "hover:bg-pink-800 hover:text-white" },
  { id: 65, name: "マンチェスターC", color: "hover:bg-sky-300" },
  { id: 73, name: "トッテナム", color: "hover:bg-gray-300" },
  { id: 5, name: "バイエルン", color: "hover:bg-red-600 hover:text-white" },
  { id: 524, name: "パリSG", color: "hover:bg-blue-900 hover:text-white" },
];
const japaneseTeams = [
  { id: 64, name: "リヴァプール", color: "hover:bg-red-700 hover:text-white" },
  { id: 397, name: "ブライトン", color: "hover:bg-blue-300" },
  { id: 57, name: "アーセナル", color: "hover:bg-red-500" },
  { id: 92, name: "Rソシエダ", color: "hover:bg-blue-700 hover:text-white" },
  { id: 547, name: "スタッドランス", color: "hover:bg-gray-300" },
  { id: 110, name: "ラツィオ", color: "hover:bg-sky-500" },
];
</script>