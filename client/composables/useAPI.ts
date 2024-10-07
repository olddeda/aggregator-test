import { useFormHelper } from '~/composables/helpers/useFormHelper'

export const useAPI = async <T>(url: string, params: any) => {
  const { token} = useAuthState()
  const formHelper = useFormHelper()

  const config = useRuntimeConfig()

  const opts = {
    key: url,
    baseURL: config.public.baseURL,
    headers: {},
    ...params
  }

  if (token.value) {
    opts.headers['Authorization'] = token.value
  }

  if (opts.body) {
    opts.body = formHelper.serialize(opts.body, {
      dotsForObjectNotation: false,
      nullsAsUndefineds: true,
      indices: true,
    })
  }

  return useFetch<T>(url, opts)
}
