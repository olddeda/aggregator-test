<script setup lang="ts">
import { useI18n } from 'vue-i18n'

const { t } = useI18n({
  useScope: 'local'
})

const route = useRoute()
const userStore = useUserStore()

const result = await userStore.show(route.params.id as string)
const item = result.data.value

useHead({
  title: t('head.title', { title: item?.login })
})
</script>

<template>
  <UDashboardPage>
    <UDashboardPanel grow>
      <UDashboardNavbar :title="t('title', { title: item?.login })" />
      <UDashboardPanelContent class="pb-24">
        <UsersShow
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
    "title": "Просмотр пользователя «{title}»",
    "head": {
      "title": "Просмотр пользователя «{title}»"
    }
  }
}
</i18n>
