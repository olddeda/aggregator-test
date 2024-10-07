<?php

namespace App\Modules\News\Models;

use DateTimeInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property DateTimeInterface $created_at
 * @property DateTimeInterface $updated_at
 *
 * @property-read News[] $news
 */
class NewsCategory extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
    ];

    /**
     * @return BelongsToMany
     */
    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}
