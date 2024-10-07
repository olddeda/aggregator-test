<script setup lang="ts">
import { AuthFormStep } from '~/enums'

defineProps({
	title: {
		type: String,
		default: undefined
	},
	description: {
		type: String,
		default: undefined
	},
	callback: {
		type: Function,
		default: () => ({})
	}
})

const { t } = useI18n({
	useScope: 'local'
})

const state = reactive({
	login: '',
	code: '',
	step: AuthFormStep.Login,
	digits: 4,
	expiredAt: new Date(new Date().getTime()),
})

const localTitle = computed(() => {
	return state.step === AuthFormStep.Code ? t('title.code') : t('title.login')
})
</script>

<template>
  <div class="gap-x-8 gap-y-4 rounded-xl flex-1 flex flex-col px-4 py-5 sm:p-6">
    <div class="w-full max-w-sm space-y-6">
      <div class="text-center">
        <div class="mb-2 pointer-events-none">
          <span class="i-heroicons-lock-closed w-8 h-8 flex-shrink-0 text-gray-900 dark:text-white" />
        </div>
        <p class="text-2xl text-gray-900 dark:text-white font-bold">
          {{ localTitle }}
        </p>
      </div>
      <div class="gap-y-6 flex flex-col">
        <AuthFormLogin
          v-if="state.step === AuthFormStep.Login"
          v-model="state"
        />
        <AuthFormCode
          v-if="state.step === AuthFormStep.Code"
          v-model="state"
          :callback="callback"
        />
      </div>
    </div>
	</div>
</template>

<i18n lang="json">
{
	"ru": {
		"title": {
			"login": "Авторизация",
			"code": "Введите код"
		}
	}
}
</i18n>
