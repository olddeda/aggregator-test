<?php

namespace App\Modules\Users\Http\Resources;

use DateTimeInterface;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Modules\Users\Enum\UserStatus;

/**
 * @property int $id
 * @property string $login
 * @property UserStatus $status
 * @property DateTimeInterface $created_at
 * @property DateTimeInterface $updated_at
 */
class UserResource extends JsonResource
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
