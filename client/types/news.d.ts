export interface News {
  id: number
  title: string
  link: string
  source: string
  description: string
  categories: string[]
  published_at: Date
  created_at: Date
  updated_at: Date
}

export interface NewsCategory {
  id: number
  title: string
}
