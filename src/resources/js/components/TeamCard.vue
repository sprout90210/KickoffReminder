<template>
  <div class="w-32 text-gray-600 flex items-center justify-center flex-col">
    <router-link
      v-if="team"
      :to="{ name: 'Team', params: { teamId: team.id } }"
      class="flex flex-col items-center hover:underline"
    >
      <div class="w-8 h-8 sm:w-12 sm:h-12 mb-1 custom-img-container">
        <img
          :src="crestUrl"
          alt="crest"
          class="custom-img"
        />
      </div>
      <p v-if="team.short_name">{{ team.short_name }}</p>
      <p v-else>{{ team.name }}</p>
    </router-link>
    <div v-else class="text-xxs">チーム情報がありません</div>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  team:{
    type: Object,
  }
});

const crestUrl = computed(() => `https://kickoffreminder-bucket.s3.ap-northeast-1.amazonaws.com/crest/${props.team.crest}`);
</script>