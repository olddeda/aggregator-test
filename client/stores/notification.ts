import type { NotificationItem } from '~/types'

interface State {
  items: NotificationItem[]
  isOpen: boolean
}

export const useNotificationStore = defineStore('notification', {
  state: (): State => {
    return <State>{
      items: [],
      isOpen: false
    }
  },
  getters: {
    countNew(state): number {
      return state.items.filter(item => item.is_new).length
    },
    hasNew(state): boolean {
      return this.countNew > 0
    },
  },
  actions: {
    add(item: NotificationItem) {
      this.items.push(item)
    },
    markIsReadAll() {
      for (const item of this.items) {
        item.is_new = false
      }
    },
    open() {
      this.isOpen = true
    },
    close() {
      this.isOpen = false
    }
  }
})
