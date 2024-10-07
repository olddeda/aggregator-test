import type { ListItem } from "~/types";
import { UserStatus } from "~/enums";

export const _useUserStatuses = () => {
  const { $i18n } = useNuxtApp()

  const items = [
    { label: $i18n.t('enum.user.status.draft'), value: UserStatus.Draft },
    { label: $i18n.t('enum.user.status.enabled'), value: UserStatus.Enabled },
    { label: $i18n.t('enum.user.status.disabled'), value: UserStatus.Disabled },
  ] as ListItem[]

  const getLabel = (status: string) => {
      return items.find(item => item.value === status)?.label
  }

  const getColor = (status: string) => {
    switch (status) {
      case UserStatus.Enabled:
        return 'green'
      case UserStatus.Disabled:
        return 'red'
      default:
        return 'orange'
    }
  }

  return {
    items,
    getLabel,
    getColor,
  }
}

export const useUserStatuses = createSharedComposable(_useUserStatuses)
