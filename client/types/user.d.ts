import { UserStatus } from "~/enums"

export interface User {
  id: number
  login: string
  status: UserStatus
  created_at: Date
  updated_at: Date
}
