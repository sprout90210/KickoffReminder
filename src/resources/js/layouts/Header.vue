<template>
  <div>
    <header class="inset-0 z-20 h-16 md:h-20 text-white flex items-center justify-center bg-gray-800">
      <router-link :to="{ name: 'Home' }" class="p-1 block text-lg md:text-3xl font-bold">
        Kickoff Reminder
      </router-link>
      <button
        @click="toggleMenu"
        class="z-50 w-9 h-10 bg-gray-800 fixed top-3 md:top-5 left-4 md:left-auto md:right-8 rounded border border-gray-600 hover:border-gray-500"
      >
        <CloseIcon v-show="isMenuOpen" class="m-auto" />
        <MenuIcon v-show="!isMenuOpen" class="m-auto" />
      </button>
    </header>
    <div
      v-if="isMenuOpen"
      @click="toggleMenu"
      class="fixed inset-0 bg-black bg-opacity-70 z-30"
    ></div>
    <HamburgerMenu />
  </div>
</template>

<script setup>
import MenuIcon from "../components/icons/MenuIcon.vue";
import CloseIcon from "../components/icons/CloseIcon.vue";
import HamburgerMenu from "./HamburgerMenu.vue";
import { computed, watch } from "vue";
import { useStore } from "vuex";

const store = useStore();
const isMenuOpen = computed(() => store.state.ui.isMenuOpen);

const toggleMenu = () => {
  store.commit("toggleMenu");
};

watch(isMenuOpen, (newValue) => {
  document.body.style.overflow = newValue ? "hidden" : "";
});
</script>
