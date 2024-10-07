<?php

namespace App\Modules\Auth\Http\Resources;

use DateTimeInterface;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
class AuthCodeResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'code' => $this->code,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
