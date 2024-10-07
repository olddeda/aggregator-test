<?php

namespace App\Modules\Auth\Data;

use DateTimeInterface;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\AlphaNumeric;

use App\Modules\Auth\Enums\AuthCodeStatus;

class AuthCodeData extends Data
{
    /**
     * @param string $login
     * @param string $code
     * @param ?AuthCodeStatus $status
     * @param ?DateTimeInterface $available_at
     */
    public function __construct(
        #[AlphaNumeric]
        public string $login,
        public string $code,
        public ?AuthCodeStatus $status,
        public ?DateTimeInterface $available_at,
    ) {}
}
