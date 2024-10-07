<script lang="ts" setup>
import { useI18n } from 'vue-i18n'
import { useAuthCodeStatuses } from '~/composables/auth/useAuthCodeStatuses'

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
  key: 'login',
  label: t('field.login'),
  sortable: true,
}, {
  key: 'code',
  label: t('field.code'),
  sortable: true,
  class: 'w-32',
}, {
  key: 'status',
  label: t('field.status'),
  sortable: true,
  class: 'w-32',
}, {
  key: 'created_at',
  label: t('field.created_at'),
  sortable: true,
  class: 'w-48',
}]

const table = ref()
const query = ref({
  'filter[status]': null,
} as any)

const statuses = useAuthCodeStatuses()

const onClearStatuses = () => {
  query.value['filter[status]'] = null
}

useHead({
  title: t('head.title')
})
</script>

<template>
  <UiTablePage
    ref="table"
    name="authCodes"
    url="/v1/auth/codes"
    :title="t('title')"
    :columns="columns"
    :query="query"
    :empty-message="t('message.empty')"
  >
    <template #toolbar-left>
      <UButtonGroup size="sm" orientation="horizontal">
        <USelectMenu
          v-model="query['filter[status]']"
          icon="i-heroicons-check-circle"
          color="gray"
          :placeholder="t('button.status')"
          :options="statuses.items"
          option-attribute="label"
          value-attribute="value"
        />
        <UButton
          v-if="query['filter[status]']"
          icon="i-heroicons-x-mark"
          color="gray"
          @click="onClearStatuses"
        />
      </UButtonGroup>
    </template>

    <template #status-data="{ row }">
      <UBadge :color="statuses.getColor(row.status)">
        {{ statuses.getLabel(row.status) }}
      </UBadge>
    </template>

    <template #created_at-data="{ row }">
      {{ $dayjs(row.created_at).format('DD-MM-YYYY HH:mm') }}
    </template>
  </UiTablePage>
</template>

<i18n lang="json">
{
  "ru": {
    "title": "Коды",
    "head": {
      "title": "Коды"
    },
    "field": {
      "id": "ID",
      "login": "Логин",
      "code": "Код",
      "status": "Статус",
      "created_at": "Дата создания"
    },
    "button": {
      "status": "Статус"
    },
    "message": {
      "error": "Ошибка",
      "empty": "Список кодов пуст"
    }
  }
}
</i18n>
