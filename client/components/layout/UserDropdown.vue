<script setup lang="ts">
import { useI18n } from 'vue-i18n'
const { signOut } = useAuth()

const { t } = useI18n({
  useScope: 'local'
})

const authStore = useAuthStore()

const items = computed(() => [
  [{
    slot: 'account',
    label: '',
    disabled: true
  }], [{
    label: t('link.logout'),
    icon: 'i-heroicons-arrow-left-on-rectangle',
    click: async () => {
      await signOut({ redirect: false })
      navigateTo('/auth')
    }
  }]
])
</script>

<template>
  <UDropdown
    mode="hover"
    :items="items"
    :ui="{ width: 'w-full', item: { disabled: 'cursor-text select-text' } }"
    :popper="{ strategy: 'absolute', placement: 'top' }"
    class="w-full"
  >
    <template #default="{ open }">
      <UButton
        color="gray"
        variant="ghost"
        class="w-full"
        :label="authStore.login"
        :class="[open && 'bg-gray-50 dark:bg-gray-800']"
      >
        <template v-if="authStore.login" #leading>
          <UAvatar
            :alt="authStore.login.toUpperCase()"
            size="2xs"
          />
        </template>

        <template #trailing>
          <UIcon name="i-heroicons-ellipsis-vertical" class="w-5 h-5 ml-auto" />
        </template>
      </UButton>
    </template>

    <template #account>
      <div class="text-left">
        <p>
          {{ t('signed_in') }}
        </p>
        <p class="truncate font-medium text-gray-900 dark:text-white">
          {{ authStore.login }}
        </p>
      </div>
    </template>
  </UDropdown>
</template>

<i18n>
{
  "ru": {
    "link": {
      "profile": "Профиль",
      "logout": "Выйти"
    },
    "signed_in": "Авторизован как"
  }
}
</i18n>
