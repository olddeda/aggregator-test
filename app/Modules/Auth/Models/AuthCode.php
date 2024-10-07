<?php

namespace App\Modules\Auth\Models;

use DateTimeInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Modules\Auth\Enums\AuthCodeStatus;

/**
 * @property int $id
 * @property string $login
 * @property string $code
 * @property AuthCodeStatus $status
 * @property DateTimeInterface $available_at
 * @property DateTimeInterface $created_at
 * @property DateTimeInterface $updated_at
 */
class AuthCode extends Model
{
    use Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'login',
        'code',
        'available_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'status' => AuthCodeStatus::class,
    ];
}
