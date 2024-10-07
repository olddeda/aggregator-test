<script setup lang="ts">
definePageMeta({
  layout: 'empty',
  auth: {
    unauthenticatedOnly: true,
    navigateAuthenticatedTo: '/',
  }
})

const { redirectedFrom } = useRoute()

const onLogin = () => {
  navigateTo(redirectedFrom ? redirectedFrom.fullPath : '/')
}
</script>

<template>
  <ULandingCard>
    <AuthForm
      :callback="onLogin"
    />
  </ULandingCard>
</template>
