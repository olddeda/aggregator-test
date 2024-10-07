<script setup lang="ts">
const props = defineProps({
	modelValue: {
		type: String,
		default: '',
	},
	digits: {
		type: Number,
		default: 4,
	},
	placeholder: {
		type: String,
		default: "0",
	},
	secure: {
		type: Boolean,
		default: false,
	},
	autofocus: {
		type: Boolean,
		default: true,
	},
	onFill: {
		type: Function,
		default: () => ({})
	}
})

const emits = defineEmits([
	'update:modelValue'
])

const inputsRefs = ref([] as any[])
const inputs = ref([] as string[])
const focusedInputIndex = ref(0)

const initialInputs = (): string[] => {
	return props.modelValue
		? props.modelValue.length <= props.digits
			? [
				...props.modelValue,
				...[...Array(props.digits - props.modelValue.length)].map(() => ""),
			]
			: [...props.modelValue.slice(0, props.digits)]
		: [...Array(props.digits)].map(() => "");
}

const init = () => {
	inputs.value = initialInputs()
}

const focusInputByIndex = (index: number) => {
	const el = inputsRefs.value[index].$el
	if (el) {
		onFocus(index)
	}
	focusedInputIndex.value = index
}

const focusPreviousInput = () => {
	if (!focusedInputIndex.value) {
		return
	}
	focusInputByIndex(focusedInputIndex.value - 1)
}

const focusNextInput = () => {
	if (focusedInputIndex.value === props.digits - 1) {
		return
	}
	focusInputByIndex(focusedInputIndex.value + 1)
}

const handleKeyDown = (e: KeyboardEvent) => {
	switch (e.key) {
		case 'LeftArrow':
			return focusPreviousInput()
		case 'RightArrow':
			return focusNextInput()
		default:
			break
	}
	const currVal = inputs.value[focusedInputIndex.value]
	if (currVal) {
		inputs.value[focusedInputIndex.value] = ""

		emits('update:modelValue', inputs.value.join(''))
	}
}

const isInputValid = (str: string | undefined, allowEmpty: boolean = true) => {
	if (!str) {
		return allowEmpty ? str === "" : false;
	}
	return !!str.match("^\\d{1}$");
}

const handleInputChange = (index: number, e: Event) => {
	const value = (e.target as HTMLInputElement).value

	if (!isInputValid(value, false)) {
		inputs.value[index] = ''
		return
	}

	inputs.value[index] = value

	emits('update:modelValue', inputs.value.join(''))

	if (+index === props.digits - 1) {
		const inputNotFillIndex = inputs.value.findIndex((v) => !v)
		inputNotFillIndex !== -1 && focusInputByIndex(inputNotFillIndex);
		props.onFill()
		return
	}

	focusNextInput()
}

const handleInputPaste = (e: ClipboardEvent) => {
	e.preventDefault()

	const value = e.clipboardData?.getData('text')
	if (!value || value.length !== props.digits) {
		return
	}

	inputs.value = value.split('')

	onFocus(props.digits - 1)
}

const handleFocus = (index: number) => {
	focusedInputIndex.value = index
	inputsRefs.value[index].$el.querySelector('input').select();
}

const handleDelete = (index: number, e: Event) => {
	const isThisCellFilled = inputs.value[index].length;
	if (!isThisCellFilled) {
		focusPreviousInput()
		e.preventDefault()
	}
}

const onFocus = (index: number) => {
	if (index < inputsRefs.value.length && inputsRefs.value[index].$el) {
		inputsRefs.value[index].$el.querySelector('input').focus()
	}
}

onMounted(() => {
	nextTick(() => {
		init()

		setTimeout(() => {
			if (props.autofocus) {
				onFocus(0)
			}
		}, 100)
	})
})
</script>

<template>
	<div class="flex gap-4 justify-center">
		<UInput
			v-for="(_, index) in inputs"
			ref="inputsRefs"
			v-model.trim="inputs[index]"
			size="xl"
			maxlength="1"
			inputmode="numeric"
			:autocomplete="!index ? 'one-time-code' : false"
			:key="index"
			:type="secure ? 'password' : 'text'"
			:placeholder="placeholder"
			:ui="{
				base: 'w-[52px] h-[52px] text-center',
				padding: {
					xl: 'p-0'
				}
			}"
			@input="handleInputChange(index, $event)"
			@paste="handleInputPaste($event)"
			@focus="handleFocus(index)"
			@keydown="handleKeyDown($event)"
			@keydown.delete="handleDelete(index, $event)"
		/>
	</div>
</template>
