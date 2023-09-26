<template>
    <header class="top-0 left-0 right-0 h-14 z-50 text-white flex items-center justify-between p-4 bg-gray-800">
        <router-link to="/" class="p-2 inline-block">
            FOOTBALL REMINDER
        </router-link>
        <router-link to="/login" class="p-2 inline-block justify-end">
            ログイン
        </router-link>
  </header>
</template>

<script>
export default {
    name: 'Header',
}
</script>
