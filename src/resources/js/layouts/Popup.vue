<template>
    <div
      role="alert"
      @click="hidePopup"
      class="transition-transform z-20 duration-300 w-full h-16 md:h-20 fixed top-0 right-0 left-0 px-12 flex items-center justify-center text-base sm:text-lg font-bold cursor-pointer text-gray-200"
      :class="[isShow ? 'translate-y-0' : '-translate-y-full', backgroundColorClass]"
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
      return 'bg-red-600';
    case 'blue':
      return 'bg-blue-500';
    case 'green':
      return 'bg-green-500';
    default:
      return 'bg-green-500';
  }
});

const hidePopup = () => {
  store.commit("hidePopup");
};
</script>
