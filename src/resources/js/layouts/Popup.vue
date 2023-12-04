<template>
  <div
    @click="hidePopup"
    :class="showPopup ? 'opacity-100 z-20' : 'opacity-0 -z-50'" class="transition-opacity duration-300 fixed top-16 left-4 sm:left-12 p-4 text-xs sm:text-sm bg-sky-200 bg-opacity-90 rounded-lg"
  >
    {{ popupMessage }}
  </div>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";

const store = useStore();
const showPopup = computed(() => store.state.showPopup);
const popupMessage = computed(() => store.state.popupMessage);
const hidePopup = () => {
  store.commit("hidePopup");
};
</script>
