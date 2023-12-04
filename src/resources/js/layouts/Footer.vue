<template>
  <footer class="w-full flex flex-col items-center p-5 bg-gray-100 text-xs">
    <div class="pt-3 flex flex-col sm:flex-row text-gray-500">
      <router-link
        to="/terms"
        class="m-2 sm:m-4 text-center hover:underline hover:text-gray-800"
      >
        利用規約
      </router-link>
      <router-link
        to="/privacy"
        class="m-2 sm:m-4 text-center hover:underline hover:text-gray-800"
      >
        プライバシーポリシー
      </router-link>
      <router-link
        to="/inquiry"
        class="m-2 sm:m-4 text-center hover:underline hover:text-gray-800"
      >
        お問合せ
      </router-link>
    </div>
    <strong class="p-6 text-gray-700">&copy; Football Reminder</strong>
  </footer>
</template>

