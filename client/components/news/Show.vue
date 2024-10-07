<script setup lang="ts">
import type { PropType } from 'vue'
import { useI18n } from 'vue-i18n'
import type { News } from '~/types'

defineProps({
  item: {
    type: Object as PropType<News>,
    required: true
  }
})

const { t } = useI18n({
  useScope: 'local'
})
</script>

<template>
  <UiRowItem :title="t('field.title')" :value="item.title" />
  <UDivider />
  <UiRowItem :title="t('field.link')">
    <NuxtLink
      :href="item.link"
      class="underline underline-offset-4 decoration-1 decoration-dashed hover:no-underline"
      target="_blank"
    >
      {{ item.link }}
    </NuxtLink>
  </UiRowItem>
  <UDivider />
  <UiRowItem :title="t('field.source')">
    <NuxtLink
      :href="item.source"
      class="underline underline-offset-4 decoration-1 decoration-dashed hover:no-underline"
      target="_blank"
    >
      {{ item.source }}
    </NuxtLink>
  </UiRowItem>
  <UDivider />
  <UiRowItem
    v-if="item.categories?.length > 0"
    :title="t('field.categories')"
  >
    <UBadge
      v-for="category in item.categories"
    >
      {{ category }}
    </UBadge>
  </UiRowItem>
  <UDivider />
  <UiRowItem :title="t('field.published_at')" :value="$dayjs(item.published_at).format('DD-MM-YYYY HH:mm')" />
  <UDivider />
  <UiRowItem :title="t('field.created_at')" :value="$dayjs(item.created_at).format('DD-MM-YYYY HH:mm')" />
  <UDivider />
  <UiRowItem :title="t('field.updated_at')" :value="$dayjs(item.updated_at).format('DD-MM-YYYY HH:mm')" />
  <UDivider />
  <div class="p-2">
    <div v-html="item.description" />
  </div>
  <div class="flex gap-2 mt-4">
    <UButton
      type="button"
      color="white"
      size="md"
      to="/news"
      leading-icon="i-heroicons-arrow-small-left"
      :label="t('button.back')"
    />
  </div>
</template>

<i18n lang="json">
{
  "ru": {
    "field": {
      "title": "Название",
      "link": "Ссылка",
      "source": "Источник",
      "description": "Описание",
      "categories": "Категории",
      "published_at": "Дата публикации",
      "created_at": "Дата создания",
      "updated_at": "Дата обновления"
    },
    "button": {
      "back": "Назад к списку"
    }
  }
}
</i18n>
