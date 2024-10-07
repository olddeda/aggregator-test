<script setup lang="ts">
import {useI18n} from 'vue-i18n'

defineProps({
  title: {
    type: String,
    required: true
  },
  value: {
    type: String,
    default: null
  }
})

const { t } = useI18n({
  useScope: 'global'
})

const slots = useSlots()
</script>

<template>
  <div class="grid md:grid-cols-2 gap-2 items-start text-sm py-3">
    <div class="flex content-center items-center justify-between">
      <label class="block font-medium text-gray-700 dark:text-gray-400">
        {{ title }}
      </label>
    </div>
    <div class="relative flex gap-1">
      <template v-if="value">
        <span class="font-normal">
          {{ value }}
        </span>
      </template>
      <template v-else-if="slots.default">
        <slot />
      </template>
      <UBadge
        v-else
        color="orange"
        variant="outline"
        class="opacity-70"
      >
        {{ t('message.empty') }}
      </UBadge>
    </div>
  </div>
</template>

<i18n lang="json">
{
  "ru": {
    "message": {
      "empty": "Не указано"
    }
  }
}
</i18n>
