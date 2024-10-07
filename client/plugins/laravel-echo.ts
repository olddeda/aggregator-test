import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

declare global {
  interface Window {
    Pusher: any
    Echo: any
  }
}

export default defineNuxtPlugin(() => {
  const config = useRuntimeConfig()

  window.Pusher = Pusher

  window.Echo = new Echo({
    broadcaster: 'reverb',
    key: config.public.REVERB_APP_KEY,
    wsHost: config.public.REVERB_HOST,
    wsPort: config.public.REVERB_PORT,
    wssPort: config.public.REVERB_PORT,
    forceTLS: (config.public.REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    authorizer: (channel: any) => {
      return {
        authorize: async (socketId: any, callback: Function) => {
          try {
            const response = await useAPI('/broadcasting/auth', {
              method: 'POST',
              body: {
                socket_id: socketId,
                channel_name: channel.name
              }})

            callback(null, response)
          } catch (error) {
            callback(error)
          }
        }
      }
    },
  })
})
