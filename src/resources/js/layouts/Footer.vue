<template>
    <footer class="w-full pt-4 flex flex-col items-center justify-center bg-gray-100 text-xs text-gray">
        <strong class="">&copy; Football Reminder</strong>
        <div class="p-4 flex flex-col sm:flex-row">
            <router-link to="/terms" class="m-2 sm:m-4 text-center hover:underline">
                利用規約
            </router-link>
            <router-link to="/privacy" class="m-2 sm:m-4 text-center hover:underline">
                プライバシーポリシー
            </router-link>
            <router-link to="/inquiry" class="m-2 sm:m-4 text-center hover:underline">
                お問合せ
            </router-link>
        </div>
    </footer>
</template>

<script>
export default {
    name: 'Footer',
}
</script>
