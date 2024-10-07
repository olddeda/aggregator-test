<?php

namespace App\Modules\Auth\Data;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\AlphaNumeric;

class AuthData extends Data
{
    /**
     * @param string $login
     */
    public function __construct(
        #[AlphaNumeric]
        public string $login
    ) {}

    /**
     * @return array
     */
    public static function messages(): array
    {
        return [
            'login.required' => __('auth.error.login.empty'),
        ];
    }
}
