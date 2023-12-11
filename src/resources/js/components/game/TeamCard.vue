<template>
  <div class="w-24 sm:w-32 flex items-center justify-center flex-col">
    <router-link
      v-if="team"
      :to="{ name: 'TeamDetail', params: { teamId: team.id } }"
      class="flex flex-col items-center hover:underline"
    >
      <div class="w-7 h-7 sm:w-9 sm:h-9 mb-2 flex items-center">
        <img
          :src="crestUrl"
          alt="crest"
          class="w-full h-auto max-h-full object-contain"
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

const crestUrl = computed(() => { return "/images/crest/" + props.team.crest; });

</script>