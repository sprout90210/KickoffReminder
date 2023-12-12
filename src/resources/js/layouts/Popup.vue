<template>
    <div
      role="alert"
      @click="hidePopup"
      class="transition-transform opacity-90 z-10 duration-300 bg-green-400 p-3.5 mr-20 rounded-md fixed top-16 sm:top-20 left-0 text-xs sm:text-sm cursor-pointer"
      :class="showPopup ? 'translate-x-3 sm:translate-x-10' : '-translate-x-full'"
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
