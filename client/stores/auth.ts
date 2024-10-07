import type { AuthForm, AuthCodeForm, User } from '~/types'

interface State {
  data: User | undefined
}

export const useAuthStore = defineStore('auth', {
  state: (): State => {
    return <State>{
      data: undefined
    }
  },
  getters: {
    isLogged: (state: State) => {
      return state.data !== undefined
    },
    login: (state: State) => {
      return state.data?.login
    }
  },
  actions: {
    init() {
      const { data } = useAuth()
      const user = data.value as unknown as User
      if (user) {
        this.data = user
      }
    },
    auth(data?: any){
      return useAPI<AuthForm>('/v1/auth', {
        method: 'POST',
        body: data
      })
    },
    authCode(data?: any){
      return useAPI<AuthCodeForm>('/v1/auth/code', {
        method: 'POST',
        body: data,
      })
    },
    async logout(){
      const { data, setToken } = useAuthState()

      await useAPI<AuthCodeForm>('/v1/auth/logout', {
        method: 'POST',
      })

      setToken(null)
      data.value = undefined
      this.data = undefined
    }
  }
})
