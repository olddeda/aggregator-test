// @ts-ignore
export default defineI18nConfig(() => ({
  legacy: false,
  locale: 'ru',
  fallbackLocale: 'ru',
  numberFormats: {
    ru: {
      currency: {
        style: 'currency', currency: 'RUB', minimumFractionDigits: 0, maximumFractionDigits: 0
      },
      decimal: {
        style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2
      },
      percent: {
        style: 'percent', useGrouping: false
      }
    },
  },
  pluralRules: {
    ru: (choice: number, choicesLength: number): number => {
      if (choice === 0) {
        return 0
      }

      const teen = choice > 10 && choice < 20
      const endsWithOne = choice % 10 === 1

      if (choicesLength < 4) {
        return (!teen && endsWithOne) ? 1 : 2
      }

      if (!teen && endsWithOne) {
        return 1
      }
      if (!teen && choice % 10 >= 2 && choice % 10 <= 4) {
        return 2
      }

      return (choicesLength < 4) ? 2 : 3
    }
  }
}))
