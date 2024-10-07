<script setup lang="ts">
import { useI18n } from "vue-i18n"

const { t } = useI18n({
  useScope: 'local'
})

const notificationStore = useNotificationStore()

const onClick = () => {
  notificationStore.open()
}
</script>

<template>
  <UTooltip
    :text="t('title')"
    :shortcuts="['N']"
  >
    <UButton
      color="gray"
      variant="ghost"
      square
      @click="onClick"
    >
      <UChip
        v-if="notificationStore.hasNew"
        color="red"
        inset
      >
        <UIcon
          name="i-heroicons-bell"
          class="w-5 h-5"
        />
      </UChip>
      <UIcon
        v-else
        name="i-heroicons-bell"
        class="w-5 h-5"
      />
    </UButton>
  </UTooltip>
</template>

<i18n lang="json">
{
  "ru": {
    "title": "Уведомления"
  }
}
</i18n>
