import type { User } from '~/types'

export const useUserStore = defineStore('user', {
  actions: {
    show(id: string) {
      return useAPI<User>('/v1/users/' + id, {})
    },
  }
})
