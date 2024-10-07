import type { News } from '~/types'

export const useNewsStore = defineStore('news', {
  actions: {
    show(id: string) {
      return useAPI<News>('/v1/news/' + id, {})
    },
  },
})
