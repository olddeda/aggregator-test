<script setup lang="ts">
import { formatTimeAgo } from '@vueuse/core'
import { useI18n } from "vue-i18n"
import type { NotificationDataNews, NotificationDataUsers, NotificationItem } from "~/types"
import { NotificationType } from "~/enums"

const { t } = useI18n({
  useScope: 'local'
})

const toast = useToast()
const notificationStore = useNotificationStore()

const addNotification = (type: NotificationType, body: string): void => {
  const item = {
    id: notificationStore.items.length + 1,
    is_new: true,
    created_at: new Date(),
    type,
    body,
  } as NotificationItem

  notificationStore.add(item)

  toast.add({
    icon: 'i-heroicons-chat-bubble-bottom-center-text-16-solid',
    color: 'green',
    title: t('notification.title'),
    description: body,
  })
}

const getLabel = (item: NotificationItem) => {
  switch (item.type) {
    case NotificationType.News:
      return t('type.news')
    default:
      return t('type.users')
  }
}

const getIcon = (item: NotificationItem) => {
  switch (item.type) {
    case NotificationType.News:
      return 'i-heroicons-table-cells'
    default:
      return 'i-heroicons-user-group'
  }
}

const items = computed(
  () => notificationStore.items.slice()
    .sort((a: NotificationItem, b: NotificationItem) => b.created_at.getTime() - a.created_at.getTime())
)

watch(() => notificationStore.isOpen, (newValue: boolean) => {
  if (!newValue) {
    notificationStore.markIsReadAll()
  }
})

onMounted(() => {
  window.Echo.channel('users').listen('.auth', function (data: NotificationDataUsers) {
    const body = t('notification.users.' + data.type, { login: data.login })
    addNotification(NotificationType.Users, body)
  })

  window.Echo.channel('news').listen('.added.count', function (data: NotificationDataNews) {
    const body = t('notification.news.count', data.count)
    addNotification(NotificationType.News, body)
  })
})

onUnmounted(() => {
  window.Echo.channel('users').stopListening('.auth')
  window.Echo.channel('news').stopListening('.added.count')
})
</script>

<template>
  <UDashboardSlideover
    v-model="notificationStore.isOpen"
    :title="t('title')"
  >
    <template v-if="items.length">
        <div
          v-for="notification in items"
          :key="notification.id"
          class="p-3 rounded-md hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer flex items-center gap-3 relative"
        >
          <UChip
            color="red"
            :show="notification.is_new"
            inset
          >
            <UIcon
              :name="getIcon(notification)"
              class="w-8 h-8"
            />
          </UChip>
          <div class="text-sm flex-1">
            <p class="flex items-center justify-between">
              <span class="text-gray-900 dark:text-white font-medium">
                {{ getLabel(notification) }}
              </span>
              <time
                :datetime="$dayjs(notification.created_at).format('DD-MM-YYYY HH:mm:ss')"
                class="text-gray-500 dark:text-gray-400 text-xs"
                v-text="formatTimeAgo(notification.created_at)"
              />
            </p>
            <p class="text-gray-500 dark:text-gray-400">
              {{ notification.body }}
            </p>
          </div>
        </div>
    </template>
    <span v-else>
      {{ t('message.empty') }}
    </span>
  </UDashboardSlideover>
</template>

<i18n lang="json">
{
  "ru": {
    "title": "Уведомления",
    "type": {
      "users": "Пользователи",
      "news": "Новости"
    },
    "notification": {
      "title": "Новое событие",
      "users": {
        "signup": "Пользователь {login} зарегистрировался в системе",
        "login": "Пользователь {login} авторизовался в системе"
      },
      "news": {
        "count": "Добавлено {n} новостей | Добавлена {n} новость | Добавлено {n} новости | Добавлено {n} новостей"
      }
    },
    "message": {
      "empty": "Пока нет новых уведомлений"
    }
  }
}
</i18n>
