

export const useFormHelper = () => {
  const isUndefined = (value: any): boolean => value === undefined

  const isNull = (value: any): boolean => value === null

  const isBoolean = (value: any): boolean =>  typeof value === 'boolean'

  const isObject = (value: any): boolean =>  value === Object(value)

  const isString = (value: any): boolean => typeof value === 'string' || value instanceof String

  const isNumber = (value?: string | number): boolean => ((value != null) && (value !== '') && !isNaN(Number(value.toString())))

  const isArray = (value: any): boolean => Array.isArray(value)

  const isDate = (value: any): boolean => value instanceof Date

  const isBlob = (value: any): boolean => isObject(value) &&
      typeof value.size === 'number' &&
      typeof value.type === 'string' &&
      typeof value.slice === 'function'

  const isFile = (value: any): boolean => isBlob(value) &&
      typeof value.name === 'string' &&
      (isObject(value.lastModifiedDate) || typeof value.lastModified === 'number')

  const initCfg = (value: any): any => isUndefined(value) ? false : value

  const serialize = (
    obj: any,
    cfg: any = null,
    fd: any = null,
    pre: any = null
  ): any => {
    cfg = cfg || {}
    fd = fd || new FormData()

    cfg.indices = initCfg(cfg.indices)
    cfg.nullsAsUndefineds = initCfg(cfg.nullsAsUndefineds)
    cfg.booleansAsIntegers = initCfg(cfg.booleansAsIntegers)
    cfg.allowEmptyArrays = initCfg(cfg.allowEmptyArrays)
    cfg.noAttributesWithArrayNotation = initCfg(
      cfg.noAttributesWithArrayNotation,
    )
    cfg.noFilesWithArrayNotation = initCfg(cfg.noFilesWithArrayNotation)
    cfg.dotsForObjectNotation = initCfg(cfg.dotsForObjectNotation)

    if (isUndefined(obj)) {
      return fd
    }
    else if (isNull(obj)) {
      if (!cfg.nullsAsUndefineds) {
        fd.append(pre, '')
      } else {
        return fd
      }
    }
    else if (isBoolean(obj)) {
      if (cfg.booleansAsIntegers) {
        fd.append(pre, obj ? 1 : 0)
      } else {
        fd.append(pre, obj)
      }
    } else if (isArray(obj)) {
      if (obj.length) {
        obj.forEach((value: any, index: number) => {
          let key = pre + '[' + (cfg.indices ? index : '') + ']'

          if (
            cfg.noAttributesWithArrayNotation ||
            (cfg.noFilesWithArrayNotation && isFile(value))
          ) {
            key = pre
          }

          serialize(value, cfg, fd, key)
        })
      }
      else if (cfg.allowEmptyArrays) {
        fd.append(cfg.noAttributesWithArrayNotation ? pre : pre + '[]', '')
      }
    }
    else if (isDate(obj)) {
      fd.append(pre, obj.toISOString())
    }
    else if (isObject(obj) && !isBlob(obj)) {
      Object.keys(obj).forEach((prop) => {
        const value = obj[prop]

        if (isArray(value)) {
          while (prop.length > 2 && prop.lastIndexOf('[]') === prop.length - 2) {
            prop = prop.substring(0, prop.length - 2)
          }
        }

        const key = pre
          ? cfg.dotsForObjectNotation
            ? pre + '.' + prop
            : pre + '[' + prop + ']'
          : prop

        serialize(value, cfg, fd, key)
      })
    } else {
      fd.append(pre, obj)
    }

    return fd
  }

  return {
    isUndefined,
    isNull,
    isBoolean,
    isNumber,
    isString,
    isObject,
    isArray,
    isBlob,
    isFile,
    serialize,
  }
}
