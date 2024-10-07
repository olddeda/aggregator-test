<script setup lang="ts">
import type { DashboardSidebarLink } from "#ui-pro/types";
import type { Group } from "#ui/types";

const { t } = useI18n({
  useScope: 'local'
})

const links = reactive([
  {
    label: t('link.news'),
    icon: 'i-heroicons-table-cells',
    to: '/news',
    tooltip: {
      text: t('link.news'),
      shortcuts: ['G', 'N']
    }
  },
  {
    label: t('link.users'),
    icon: 'i-heroicons-user-group',
    to: '/users',
    tooltip: {
      text: t('link.users'),
      shortcuts: ['G', 'U']
    }
  },
  {
    label: t('link.auth.codes'),
    icon: 'i-heroicons-key',
    to: '/auth/codes',
    tooltip: {
      text: t('link.auth.codes'),
      shortcuts: ['G', 'A']
    }
  },
] as DashboardSidebarLink[])

const groups = [{
  key: 'links',
  label: t('link.go'),
  commands: links.map(link => ({ ...link, shortcuts: link.tooltip?.shortcuts }))
} as {}] as Group[]
</script>

<template>
  <UDashboardLayout>
    <UDashboardPanel :width="250" :resizable="{ min: 200, max: 300 }" collapsible>
      <UDashboardSidebar>
        <template #header>
          <UDashboardSearchButton
            :label="t('placeholder.search')"
          />
        </template>

        <UDashboardSidebarLinks
          :links="links"
        />

        <div class="flex-1" />

        <UDivider class="sticky bottom-0" />

        <template #footer>
          <LayoutUserDropdown />
        </template>
      </UDashboardSidebar>
    </UDashboardPanel>

    <slot />

    <NotificationSlideover />

    <LazyUDashboardSearch
      :groups="groups"
    />
  </UDashboardLayout>
</template>


<i18n lang="json">
{
  "ru": {
    "link": {
      "news": "Новости",
      "users": "Пользователи",
      "auth": {
        "codes": "Коды"
      },
      "go": "Перейти к"
    },
    "placeholder": {
      "search": "Поиск..."
    }
  }
}
</i18n>

