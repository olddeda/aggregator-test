<script setup lang="ts">

const authStore = useAuthStore()
authStore.init()

</script>

<template>
    <div class="relative">
        <NuxtLoadingIndicator />

        <NuxtLayout>
            <NuxtPage />
        </NuxtLayout>

        <UNotifications />
        <UModals />
    </div>
</template>

