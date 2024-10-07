import type { User } from "~/types"

export default defineNuxtConfig({
  compatibilityDate: '2024-04-03',
  ssr: false,

  devtools: {
    enabled: true
  },

  runtimeConfig: {
    public: {
      baseURL: process.env.NUXT_PUBLIC_API_URL,
      REVERB_APP_ID: process.env.REVERB_APP_ID ?? '',
      REVERB_APP_KEY: process.env.REVERB_APP_KEY ?? '',
      REVERB_HOST: process.env.REVERB_HOST ?? 'localhost',
      REVERB_PORT: parseInt(process.env.REVERB_PORT ?? '0'),
      REVERB_SCHEME: process.env.REVERB_SCHEME ?? 'HTTPS',
    },
  },

  css: [
    '~/assets/scss/app.scss'
  ],

  icon: {
    serverBundle: {
      collections: ['heroicons', 'svg-spinners']
    },
  },

  extends: [
    '@nuxt/ui-pro'
  ],

  modules: [
    '@nuxt/ui',
    '@nuxtjs/i18n',
    '@sidebase/nuxt-auth',
    '@vueuse/nuxt',
    [
      '@pinia/nuxt',
      {
        autoImports: ['defineStore', 'acceptHMRUpdate'],
      },
    ],
  ],

  i18n: {
    vueI18n: './i18n.config.ts',
    defaultLocale: 'ru',
    locales: [
      {
        code: 'ru',
        file: 'ru.ts'
      }
    ],
    lazy: false,
    langDir: 'lang'
  },

  auth: {
    globalAppMiddleware: true,
    baseURL: process.env.NUXT_PUBLIC_API_URL + '/v1/auth/',
    provider: {
      type: 'local',
      endpoints: {
        signIn: { path: 'code', method: 'post' },
        signOut: { path: 'logout', method: 'post' },
        getSession: { path: 'me', method: 'get' },
      },
      pages: {
        login: '/auth'
      },
      token: {
        maxAgeInSeconds: 86400 * 365,
        sameSiteAttribute: true,
      }
    }
  },

  vite: {
    css: {
      preprocessorOptions: {
        scss: {
          api: 'modern',
        },
      },
    },
  }
})
