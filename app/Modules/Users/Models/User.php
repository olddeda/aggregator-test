<?php

namespace App\Modules\Users\Models;

use DateTimeInterface;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

use App\Modules\Users\Enum\UserStatus;

/**
 * @property int $id
 * @property string $login
 * @property UserStatus $status
 * @property DateTimeInterface $created_at
 * @property DateTimeInterface $updated_at
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'login',
        'status',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'status' => UserStatus::class,
    ];
}
