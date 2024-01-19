<template>
    <div
      role="alert"
      @click="hidePopup"
      class="transition-transform opacity-90 z-10 duration-300 p-3.5 mr-20 rounded-md fixed top-20 md:top-24 left-0 text-xs sm:text-sm cursor-pointer"
      :class="[isShow ? 'translate-x-3 sm:translate-x-10' : '-translate-x-full', backgroundColorClass]"
    >
      {{ message }}
    </div>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";

const store = useStore();
const isShow = computed(() => store.state.ui.showPopup);
const message = computed(() => store.state.ui.popupMessage);
const color = computed(() => store.state.ui.popupColor);
const backgroundColorClass = computed(() => {
  switch (color.value) {
    case 'red':
      return 'bg-red-400';
    case 'blue':
      return 'bg-blue-300';
    case 'green':
      return 'bg-green-400';
    default:
      return 'bg-green-400';
  }
});

const hidePopup = () => {
  store.commit("hidePopup");
};
</script>
