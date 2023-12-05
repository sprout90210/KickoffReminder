<template>
  <div>
    <header
      class="top-0 left-0 h-14 sm:h-16 z-30 text-white flex items-center bg-gray-800"
    >
      <router-link to="/" class="ml-5 p-1 inline-block text-md font-semibold">Kickoff Reminder</router-link>
      <button @click="toggleMenu" class="z-50 w-8 h-9 bg-gray-800 fixed top-2.5 sm:top-3.5 right-3 sm:right-6 rounded border border-gray-600 hover:border-gray-500">
        <i class="fas duration-300" :class="isMenuOpen ? 'fa-times -rotate-90' : 'fa-bars'"></i>
      </button>
    </header>
    <div
      v-if="isMenuOpen"
      class="fixed inset-0 bg-black bg-opacity-70 z-30"
      @click="toggleMenu"
    ></div>
    <HamburgerMenu />
  </div>
</template>

<script setup>
import HamburgerMenu from "./HamburgerMenu.vue";
import { computed, watch } from "vue";
import { useStore } from "vuex";

const store = useStore();
const isMenuOpen = computed(() => store.state.isMenuOpen);

const toggleMenu = () => {
  store.commit("toggleMenu");
};

watch(isMenuOpen, (newValue) => {
  document.body.style.overflow = newValue ? "hidden" : "";
});
</script>
