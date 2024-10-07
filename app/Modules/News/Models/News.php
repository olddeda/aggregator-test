<?php

namespace App\Modules\News\Models;

use DateTimeInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $guid
 * @property string $title
 * @property string $link
 * @property string $source
 * @property array $description
 * @property DateTimeInterface $published_at
 * @property DateTimeInterface $created_at
 * @property DateTimeInterface $updated_at
 *
 * @property-read NewsCategory[] $categories
 */
class News extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'guid',
        'title',
        'link',
        'source',
        'description',
        'published_at',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            related: NewsCategory::class,
            table: 'news_to_categories',
            foreignPivotKey: 'news_id',
            relatedPivotKey: 'category_id'
        );
    }
}
