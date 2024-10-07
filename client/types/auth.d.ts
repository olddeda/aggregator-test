import type { User } from '~/types'
import { AuthCodeStatus } from "~/enums";

export interface AuthCode {
  id: number
  login: string
  code: string
  status: AuthCodeStatus
  created_at: Date
  updated_at: Date
}

export interface AuthForm {
	seconds: number
	digits: number
}

export interface AuthCodeForm {
	user: User
	token: string
}
