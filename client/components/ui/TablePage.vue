<script setup lang="ts">
import { StorageSerializers, useStorage } from '@vueuse/core'
import { useI18n } from 'vue-i18n'
import type { Pagination } from '~/types'
import type { DropdownItem } from '#ui/types'

const { t } = useI18n({
  useScope: 'local'
})

const props = defineProps({
  name: {
    type: String,
    required: true
  },
  title: {
    type: String,
    required: true
  },
  url: {
    type: String,
    required: true
  },
  columns: {
    type: Array,
    required: true
  },
  actions: {
    type: Array,
    default: () => ([])
  },
  query: {
    type: Object,
    default: () => ({})
  },
  emptyMessage: {
    type: String,
    default: 'Empty data'
  },
  emptyIcon: {
    type: String,
    default: 'i-heroicons-circle-stack-20-solid',
  },
  sortDefault: {
    type: String,
    default: 'id'
  },
  onCreate: {
    type: Function,
    default: () => ({})
  },
  onUpdate: {
    type: Function,
    default: () => ({})
  },
  onDelete: {
    type: Function,
    default: () => ({})
  },
  canCreate: {
    type: Boolean,
    default: false
  },
  canUpdate: {
    type: Boolean,
    default: false
  },
  canUpdateCallback: {
    type: Function,
    default: null
  },
  canDelete: {
    type: Boolean,
    default: false
  },
  canDeleteCallback: {
    type: Function,
    default: null
  }
})

const emits = defineEmits([
  'update:query'
])

const localQuery = computed({
  get: () => props.query,
  set: (value) => emits('update:query', value)
})

const onRefresh = () => {
  refresh()
}

defineExpose({
  onRefresh
})

const key = 'table.page.' + props.name

const checkCanUpdate = (row: any) => {
  return props.canUpdateCallback ? props.canUpdateCallback(row) : props.canUpdate
}

const checkCanDelete = (row: any) => {
  return props.canDeleteCallback ? props.canDeleteCallback(row) : props.canDelete
}

const actionsItems = (row: any) => {
  const defaultActions = []

  if (checkCanUpdate(row)) {
    defaultActions.push({
      label: t('action.update'),
      icon: 'i-heroicons-pencil-solid',
      click: () => props.onUpdate(row)
    })
  }
  if (checkCanDelete(row)) {
    defaultActions.push({
      label: t('action.delete'),
      icon: 'i-heroicons-trash-20-solid',
      click: () => props.onDelete(row)
    })
  }

  return [[...defaultActions, ...props.actions]] as DropdownItem[][]
}

const search = ref('')
const page = ref(1)
const input = ref<{ input: HTMLInputElement }>()

const sort = ref({
  column: props.sortDefault,
  direction: 'asc'
} as any)

const sortQuery = computed(() => {
  return sort.value.direction == 'desc' ? '-' + sort.value.column : sort.value.column
})

const savedQuery = useStorage(key + '.query', {
  'filter[query]': search.value,
  sort: sortQuery.value,
  page: page.value,
  ...localQuery.value
}, undefined, {
  serializer: StorageSerializers.object
})

for (const key in savedQuery.value) {
  if (key !== 'filter[query]' && key !== 'page') {
    localQuery.value[key] = savedQuery.value[key]
  }
}

search.value = savedQuery.value['filter[query]']
sort.value.column = savedQuery.value.sort
sort.value.direction = savedQuery.value.sort.includes('-') ? 'desc' : 'asc'
page.value = savedQuery.value.page

const currentQuery = computed(() => ({
  'filter[query]': search.value,
  sort: sortQuery.value,
  page: page.value,
  ...localQuery.value
}))

let oldQuery = { ...currentQuery.value } as any

const savedColumns = useCookie(key + '.columns', {
  default: () => props.columns?.filter((c: any) => {
    if (c.key === 'actions') {
      return true
    }
    if (c.default !== undefined) {
      return c.default
    }
    return true
  }).map((c: any) => c.key),
})

const selectedColumns = ref(props.columns?.filter((column: any) => savedColumns.value.includes(column.key)) as any[])
const selectableColumns = props.columns?.filter((column: any) => column.key !== 'actions') as any[]
const currentColumns = computed(() => props.columns.filter((column: any) => selectedColumns.value.find((c: any) => c.key === column.key)) as any[])

watch(selectedColumns, (newValue) => {
  savedColumns.value = newValue.map((c: any) => c.key)
})

const { data, pending, refresh } = await useAPI(props.url, { query: currentQuery, default: () => [] })

// @ts-ignore
const items = computed(() => data.value.data ?? [])

// @ts-ignore
const meta = computed(() => data.value.meta as Pagination ?? {})
page.value = meta.value.current_page

const pageFrom = computed(() => (page.value - 1) * meta.value.per_page + 1)
const pageTo = computed(() => Math.min(page.value * meta.value.per_page, meta.value.total))

const slots = props.columns?.filter((s:any) => s.key !== 'actions').map((column:any) => {
  return column.key + '-data'
})

watch(currentQuery, (newValue: any) => {
  for (const key in newValue) {
    if (key !== 'page' && oldQuery[key] !== newValue[key]) {
      page.value = 1
    }
  }

  savedQuery.value = newValue

  oldQuery = { ...newValue } as any
})

watch(sortQuery, (newValue) => {
  savedQuery.value['sort'] = newValue
})

defineShortcuts({
  '/': () => {
    input.value?.input?.focus()
  }
})

</script>

<template>
  <UDashboardPage>
    <UDashboardPanel grow>
      <UDashboardNavbar
        :title="title"
        :badge="meta.total ?? 0"
      >
        <template #right>
          <UInput
            ref="input"
            v-model="search"
            icon="i-heroicons-funnel"
            autocomplete="off"
            :placeholder="t('placeholder.search')"
            class="hidden lg:block"
            @keydown.esc="$event.target.blur()"
          >
            <template #trailing>
              <UKbd value="/" />
            </template>
          </UInput>

          <NotificationButton />

          <slot name="right">
            <UButton
              v-if="canCreate"
              :label="t('button.create')"
              trailing-icon="i-heroicons-plus"
              color="gray"
              @click="() => onCreate()"
            />
          </slot>
        </template>
      </UDashboardNavbar>

      <UDashboardToolbar>
        <template #left>
          <slot name="toolbar-left" />
        </template>

        <template #right>
          <USelectMenu
            v-model="selectedColumns"
            color="gray"
            icon="i-heroicons-adjustments-horizontal-solid"
            class="hidden lg:flex"
            :options="selectableColumns"
            :ui-menu="{
              option: {
                container: 'flex items-center gap-1.5 min-w-0 pr-2'
              }
            }"
            multiple
          >
            <template #label>
              {{ t('button.display') }}
            </template>
          </USelectMenu>
        </template>
      </UDashboardToolbar>

      <slot />

      <UTable
        v-model:sort="sort"
        :rows="items"
        :columns="currentColumns"
        :loading="pending"
        sort-mode="auto"
        sort-asc-icon="i-heroicons-arrow-small-up-20-solid"
        sort-desc-icon="i-heroicons-arrow-small-down-20-solid"
        class="w-full"
        :loading-state="{
          icon: 'i-heroicons-arrow-path-20-solid',
          label: t('message.loading')
        }"
        :empty-state="{
          icon: emptyIcon,
          label: emptyMessage
        }"
        :ui="{
          divide: 'divide-gray-200 dark:divide-gray-800',
          emptyState: {
            wrapper: 'flex flex-col items-center justify-center flex-1 px-6 py-6 sm:px-14',
          },
          loadingState: {
            wrapper: 'flex flex-col items-center justify-center flex-1 px-6 py-6 sm:px-14',
          }
        }"
      >
        <template
          v-for="slot in slots"
          #[slot]="slotData"
        >
          <slot
            v-bind="slotData"
            :name="slot"
          />
        </template>

        <template #actions-data="{ row }">
          <UDropdown v-if="actionsItems(row)[0].length" :items="actionsItems(row)">
            <UButton color="gray" variant="ghost" icon="i-heroicons-ellipsis-horizontal-20-solid" />
          </UDropdown>
        </template>
      </UTable>

      <UDivider />

      <div class="flex flex-wrap justify-center md:justify-between items-center my-4 mx-4">
        <UPagination
          v-model="page"
          :page-count="meta.per_page"
          :total="meta.total"
          :ui="{
            wrapper: 'flex items-center gap-1',
            rounded: '!rounded-full min-w-[32px] justify-center',
            default: {
              activeButton: {
                variant: 'outline'
              }
            }
          }"
        />
        <div class="hidden md:block">
          <span v-if="items.length" class="text-sm leading-5">
            {{ t('pagination.showing') }}
            <span class="font-bold">{{ pageFrom }}</span>
            {{ t('pagination.to') }}
            <span class="font-bold">{{ pageTo }}</span>
            {{ t('pagination.of') }}
            <span class="font-bold">{{ meta.total }}</span>
          </span>
        </div>
      </div>
    </UDashboardPanel>
  </UDashboardPage>
</template>

<i18n lang="json">
{
  "ru": {
    "placeholder": {
      "search": "Поиск..."
    },
    "action": {
      "update": "Редактировать",
      "delete": "Удалить"
    },
    "button": {
      "create": "Добавить",
      "display": "Поля"
    },
    "pagination": {
      "showing": "Показаны результаты c",
      "to": "по",
      "of": "из"
    },
    "message": {
      "empty":  "Данные найдены",
      "loading": "Загрузка..."
    }
  }
}
</i18n>
