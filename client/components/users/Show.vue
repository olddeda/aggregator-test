<script setup lang="ts">
import type { PropType } from 'vue'
import { useI18n } from 'vue-i18n'
import type { User } from '~/types'
import { useUserStatuses } from "~/composables/users/useUserStatuses";

defineProps({
  item: {
    type: Object as PropType<User>,
    required: true
  }
})

const { t } = useI18n({
  useScope: 'local'
})

const statuses = useUserStatuses()
</script>

<template>
  <UiRowItem :title="t('field.login')" :value="item.login" />
  <UDivider />
  <UiRowItem :title="t('field.login')">
    <UBadge :color="statuses.getColor(item.status)">
      {{ statuses.getLabel(item.status) }}
    </UBadge>
  </UiRowItem>
  <UDivider />
  <UiRowItem :title="t('field.created_at')" :value="$dayjs(item.created_at).format('DD-MM-YYYY HH:mm')" />
  <UDivider />
  <UiRowItem :title="t('field.updated_at')" :value="$dayjs(item.updated_at).format('DD-MM-YYYY HH:mm')" />
  <UDivider />
  <div class="flex gap-2 mt-4">
    <UButton
      type="button"
      color="white"
      size="md"
      to="/users"
      leading-icon="i-heroicons-arrow-small-left"
      :label="t('button.back')"
    />
  </div>
</template>

<i18n lang="json">
{
  "ru": {
    "field": {
      "login": "Название",
      "status": "Статус",
      "created_at": "Дата создания",
      "updated_at": "Дата обновления"
    },
    "button": {
      "back": "Назад к списку"
    }
  }
}
</i18n>
