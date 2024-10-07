<script setup lang="ts">
import { useI18n } from 'vue-i18n'

const { t } = useI18n({
  useScope: 'local'
})

const route = useRoute()
const newsStore = useNewsStore()

const result = await newsStore.show(route.params.id as string)
const item = result.data.value

useHead({
  title: t('head.title', { title: item?.title })
})
</script>

<template>
  <UDashboardPage>
    <UDashboardPanel grow>
      <UDashboardNavbar :title="t('title', { title: item?.title })">
        <template #right>
          <LayoutNotificationButton />
        </template>
      </UDashboardNavbar>
      <UDashboardPanelContent class="pb-24">
        <NewsShow
          v-if="item"
          :item="item"
        />
      </UDashboardPanelContent>
    </UDashboardPanel>
  </UDashboardPage>
</template>

<i18n lang="json">
{
  "ru": {
    "title": "Просмотр новости «{title}»",
    "head": {
      "title": "Просмотр новости «{title}»"
    }
  }
}
</i18n>
