import type { ListItem } from "~/types";
import { AuthCodeStatus } from "~/enums";

export const _useAuthCodeStatuses = () => {
  const { $i18n } = useNuxtApp()

  const items = [
    { label: $i18n.t('enum.auth.code.status.new'), value: AuthCodeStatus.New },
    { label: $i18n.t('enum.auth.code.status.used'), value: AuthCodeStatus.Used },
    { label: $i18n.t('enum.auth.code.status.expired'), value: AuthCodeStatus.Expired },
  ] as ListItem[]

  const getLabel = (status: string) => {
      return items.find(item => item.value === status)?.label
  }

  const getColor = (status: string) => {
    switch (status) {
      case AuthCodeStatus.Used:
        return 'green'
      case AuthCodeStatus.Expired:
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

export const useAuthCodeStatuses = createSharedComposable(_useAuthCodeStatuses)
