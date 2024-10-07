<script lang="ts" setup>
import { useI18n } from 'vue-i18n'
import { useUserStatuses } from "~/composables/users/useUserStatuses";

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
  'filter[status]': null
} as any)

const statuses = useUserStatuses()

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
    name="users"
    url="/v1/users"
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

    <template #login-data="{ row }">
      <NuxtLink
        :to="'/users/' + row.id"
        class="underline underline-offset-4 decoration-1 decoration-dashed hover:no-underline"
      >
        {{ row.login }}
      </NuxtLink>
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
    "title": "Пользователи",
    "head": {
      "title": "Пользователи"
    },
    "field": {
      "id": "ID",
      "login": "Логин",
      "status": "Статус",
      "created_at": "Дата регистрации"
    },
    "button": {
      "status": "Статус"
    },
    "message": {
      "error": "Ошибка",
      "empty": "Список пользователей пуст"
    }
  }
}
</i18n>
