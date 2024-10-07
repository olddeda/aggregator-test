import { NotificationType, NotificationUsersType } from "~/enums";

export interface NotificationItem {
  id: number
  type: NotificationType
  body: ?string
  is_new: boolean
  created_at: Date
}

export interface NotificationDataUsers {
  type: NotificationUsersType
  login: string
}
export interface NotificationDataNews {
  count: number
}
