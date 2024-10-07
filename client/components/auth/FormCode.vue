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
	callback: {
		type: Function,
		default: () => ({})
	}
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

const localValue = computed({
	get: () => props.modelValue,
	set: (value) => emits('update:modelValue', value)
})

const authStore = useAuthStore()
const { data: authData, setToken } = useAuthState()

const { currentTime } = useCurrentTime()

const form = ref()
const isLoading = ref(false)
const isLoadingAgain = ref(false)

const leftSeconds = computed(() => {
	const seconds =  localValue.value.expiredAt.getTime() - currentTime.value.getTime()
	return seconds > 0 ? Math.floor(seconds / 1000) : 0
})

const schema = yup.object().shape({
	code: yup
		.string()
		.test(
			'len',
			t('message.code.empty', { length: localValue.value.digits }),
			(val: string | undefined) => val?.length === localValue.value.digits)
		.required(t('message.code.empty')),
})

const isValid = computed(() => schema.isValidSync(localValue.value))

const onSubmit = async () => {
	isLoading.value = true

	const result = await authStore.authCode({
		login: localValue.value.login,
		code: localValue.value.code
	})

	isLoading.value = false

	const error = result.error?.value
	if (error) {
		onSubmitError(error)
		return
	}

	if (result.data.value?.token) {
		setToken(result.data.value.token)
	}
	if (result.data.value?.user) {
		authData.value = result.data.value.user

		authStore.$patch({
			data: result.data.value.user
		})
	}

	props.callback()
}

const onSubmitAgain = async () => {
	isLoadingAgain.value = true

	const result = await authStore.auth({
		login: localValue.value.login
	})

	isLoadingAgain.value = false

	const error = result.error?.value
	if (error) {
		onSubmitError(error)
		return
	}

	localValue.value.digits = result.data.value?.digits ?? 4
	localValue.value.expiredAt = new Date(new Date().getTime() + (result.data.value?.seconds ?? 60) * 1000)
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
		case ServerStatusCode.NotFound:
			errors.push({
				path: 'code',
				message: error.data.message
			})
			break
		case ServerStatusCode.ToEarly:
			errors.push({
				path: 'code',
				message: error.data.message
			})
			break
		case ServerStatusCode.ToManyRequests:
			errors.push({
				path: 'code',
				message: tg('error.many_requests', {
					seconds: t('plural_seconds', parseInt((error.cause as any).response.headers.get('Retry-After')))
				})
			})
			break
		default:
			break
	}
	if (errors.length) {
		form.value.setErrors(errors)
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

const onBack = () => {
	localValue.value.step = AuthFormStep.Login
}
</script>

<template>
	<UForm
		ref="form"
		:schema="schema"
		:state="localValue"
		:validate-on="['submit', 'change']"
		@submit="onSubmit"
		@error="onError"
	>
		<UFormGroup
			name="code"
			:ui="{
				label: {
					wrapper: 'flex items-center justify-center text-center mb-5',
					base: 'block text-base font-normal text-gray-600'
				},
				error: 'text-center',
				container: 'mt-3 relative'
			}"
		>
			<template #label>
				{{ t('field.code') }}
			</template>

			<template #default>
				<UiPinInput
					v-model="localValue.code"
					:digits="localValue.digits"
					:on-fill="onSubmit"
				/>
			</template>
		</UFormGroup>
		<div class="text-center mt-4">
			<UButton
				variant="link"
				:label="t('button.back_login')"
				@click="onBack"
			/>
		</div>
		<UButton
			type="submit"
			size="xl"
			class="mt-5"
			:label="t('button.submit')"
			:ui="{
				font: 'font-semibold',
				padding: {
					xl: 'px-3.5 py-3.5'
				}
			}"
			:disabled="isLoading || !isValid"
			block
		>
			<template #leading>
				<UIcon
					v-if="isLoading"
					name="i-svg-spinners-ring-resize"
					class="w-5 h-5"
					dynamic
				/>
			</template>
		</UButton>
		<div class="mt-3 text-center text-xs">
			<template v-if="leftSeconds">
				{{ t('message.send_again_after', {
					seconds: t('plural.seconds', leftSeconds)
				}) }}
			</template>
			<template v-else>
				<template v-if="isLoadingAgain">
					{{ t('button.again_send') }}
				</template>
				<UButton
					v-else
					variant="link"
					size="xs"
					class="my-0 py-0"
					:label="t('button.again')"
					@click="onSubmitAgain"
				/>
			</template>
		</div>
	</UForm>
</template>

<i18n lang="json">
{
	"ru": {
		"field": {
			"code": "Введите код из сообщения в телеграмм"
		},
		"plural": {
			"seconds": "{n} секунд | {n} секунду | {n} секунды | {n} секунд"
		},
		"button": {
			"submit": "Отправить",
			"again": "Запросить код снова",
			"again_send": "Запрашиваем новый код...",
			"back_login": "Изменить логин"
		},
		"message": {
			"code": {
				"empty": "Вы не ввели код",
				"length": "Код должен состоять из {length} чисел"
			},
			"send_again_after": "Запросить код повторно через {seconds}"
		}
	}
}
</i18n>
