<script lang="ts" setup>
import { useI18n } from 'vue-i18n'

const { t } = useI18n({
  useScope: 'local'
})

const columns = [{
  key: 'id',
  label: t('field.id'),
  sortable: true,
  default: true,
  class: 'w-20',
}, {
  key: 'title',
  label: t('field.title'),
  sortable: true,
  default: true
}, {
  key: 'link',
  label: t('field.link'),
  sortable: true,
  default: true
}, {
  key: 'source',
  label: t('field.source'),
  sortable: true,
  default: true
}, {
  key: 'categories',
  label: t('field.categories'),
  sortable: false,
  default: true
}, {
  key: 'published_at',
  label: t('field.published_at'),
  sortable: true,
  default: true
}]

const table = ref()
const query = ref({})

useHead({
  title: t('head.title')
})
</script>

<template>
  <UiTablePage
    ref="table"
    name="news"
    url="/v1/news"
    :title="t('title')"
    :columns="columns"
    :query="query"
    :empty-message="t('message.empty')"
  >
    <template #title-data="{ row }">
      <NuxtLink
        :to="'/news/' + row.id"
        class="underline underline-offset-4 decoration-1 decoration-dashed hover:no-underline"
      >
        {{ row.title }}
      </NuxtLink>
    </template>

    <template #link-data="{ row }">
      <NuxtLink
        :href="row.link"
        class="underline underline-offset-4 decoration-1 decoration-dashed hover:no-underline"
        target="_blank"
      >
        {{ row.link }}
      </NuxtLink>
    </template>

    <template #categories-data="{ row }">
      <div
        v-if="row.categories?.length > 0"
        class="flex gap-1"
      >
        <UBadge
          v-for="category in row.categories"
        >
          {{ category }}
        </UBadge>
      </div>
      <span v-else>-</span>
    </template>

    <template #published_at-data="{ row }">
      {{ $dayjs(row.published_at).format('DD-MM-YYYY HH:mm') }}
    </template>
  </UiTablePage>
</template>

<i18n lang="json">
{
  "ru": {
    "title": "Новости",
    "head": {
      "title": "Новости"
    },
    "field": {
      "id": "ID",
      "title": "Название",
      "link": "Ссылка",
      "source": "Источник",
      "categories": "Категории",
      "published_at": "Дата публикации"
    },
    "button": {
      "status": "Статус"
    },
    "message": {
      "error": "Ошибка",
      "empty": "Список новостей пуст"
    }
  }
}
</i18n>
