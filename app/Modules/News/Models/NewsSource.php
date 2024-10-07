<?php

namespace App\Modules\News\Models;

use DateTimeInterface;

use Illuminate\Database\Eloquent\Model;

use App\Modules\News\Enums\NewsSourceStatus;
use App\Modules\News\Enums\NewsSourceType;

/**
 * @property int $id
 * @property NewsSourceType $type
 * @property NewsSourceStatus $status
 * @property string $url
 * @property string $last_error
 * @property DateTimeInterface $created_at
 * @property DateTimeInterface $updated_at
 *
 * @property-read News[] $news
 */
class NewsSource extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
        'status',
        'url',
        'last_error',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'type' => NewsSourceType::class,
        'status' => NewsSourceStatus::class,
    ];
}
