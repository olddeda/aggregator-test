export default {
  enum: {
    user: {
      status: {
        draft: 'Новый',
        enabled: 'Активен',
        disabled: 'Заблокирован'
      },
    },
    auth: {
      code: {
        status: {
          new: 'Новый',
          used: 'Использован',
          expired: 'Срок истек'
        },
      },
    }
  },
  notification: {
    title: 'Новое событие',
  },
  message: {
    empty: 'Не указано'
  },
  error: {
    access: 'У вас нет прав к этой странице'
  }
}
