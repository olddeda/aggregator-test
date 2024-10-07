<script setup lang="ts">
import * as yup from 'yup'
import type { FormErrorEvent } from '#ui/types'
import { ServerStatusCode } from '~/enums/server'
import { AuthFormStep } from '~/enums'

const props = defineProps({
	modelValue: {
		type: Object,
		required: true
	},
})

const emits = defineEmits([
	'update:modelValue'
])

const { t: tg } = useI18n({
	useScope: 'global'
})

const { t } = useI18n({
	useScope: 'local'
})

const toast = useToast()

const localValue = computed({
	get: () => props.modelValue,
	set: (value) => emits('update:modelValue', value)
})

const authStore = useAuthStore()

const form = ref()
const isLoading = ref(false)

const	schema = yup.object().shape({
  login: yup.string()
    .required(t('message.login.empty'))
    .matches(/^[aA-zZ0-9\s]+$/, t('message.login.invalid')),
})

const onSubmit = async () => {
	isLoading.value = true

	const result = await authStore.auth({
		login: localValue.value.login
	})

	isLoading.value = false

	const error = result.error?.value
	if (error) {
		onSubmitError(error)
		return
	}

	localValue.value.digits = result.data.value?.digits ?? 4
	localValue.value.expiredAt = new Date(new Date().getTime() + (result.data.value?.seconds ?? 60) * 1000)
	localValue.value.step = AuthFormStep.Code
}

const onSubmitError = (error: any) => {
	const errors: any[] = []
	switch (error.statusCode) {
		case ServerStatusCode.UnprocessableContent:
			Object.entries(error.data.errors).forEach(([key, value]) => {
				errors.push({
					path: key,
					message: (value as Array<string>).join('')
				})
			})
			break
		case ServerStatusCode.ToEarly:
			errors.push({
				path: 'login',
				message: error.data.message
			})
			break
		case ServerStatusCode.ToManyRequests:
			errors.push({
				path: 'login',
				message: tg('error.many_requests', {
					seconds: t('plural.seconds', parseInt((error.cause as any).response.headers.get('Retry-After')))
				})
			})
			break
		default:
			break
	}
	if (errors.length) {
    toast.add({
      color: 'red',
      icon: 'i-heroicons-exclamation-circle-16-solid',
      title: t('message.error'),
      description: errors[0].message,
    })
	}
}

const onError = (event: FormErrorEvent) => {
	const element = document.getElementById(event.errors[0].id)
	element?.focus()
	element?.scrollIntoView({
		behavior: 'smooth',
		block: 'center'
	})
}
</script>

<template>
  <p class="text-gray-500 dark:text-gray-400 mt-1">
    {{ t('description') }}
  </p>
  <UForm
    ref="form"
    :schema="schema"
    :state="localValue"
    :validate-on="['submit', 'change', 'input']"
    @submit="onSubmit"
    @error="onError"
  >
    <UFormGroup
      :label="t('field.login')"
      name="login"
      size="xl"
    >
      <UInput
        id="login"
        v-model="localValue.login"
        color="gray"
        size="xl"
        :placeholder="t('placeholder.login')"
      />
    </UFormGroup>

    <UButton
      type="submit"
      class="mt-4"
      :loading="isLoading"
      size="xl"
      block
    >
      {{ t('button.submit') }}
    </UButton>
  </UForm>
</template>

<i18n lang="json">
{
	"ru": {
    "description": "Для доступа в панель управления введите ваши данные",
		"field": {
			"login": "Ваш логин"
		},
		"placeholder": {
			"login": "Введите ваш логин"
		},
		"button": {
			"submit": "Получить код"
		},
    "plural": {
      "seconds": "{n} секунд | {n} секунду | {n} секунды | {n} секунд"
    },
		"message": {
      "error": "Ошибка",
			"login": {
				"empty": "Вы не ввели логин",
        "invalid": "Только латинские символы"
			},
			"send_again_after": "Запросить код повторно через {seconds}"
		}
	}
}
</i18n>
