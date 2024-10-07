<?php

namespace App\Modules\News\Http\Resources;

use DateTimeInterface;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Collection;

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
 * @property-read Collection $categories
 */
class NewsResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'guid' => $this->guid,
            'title' => $this->title,
            'link' => $this->link,
            'source' => $this->source,
            'description' => $this->description,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'categories' => array_map(fn (array $category) => $category['title'], $this->categories->toArray()),
        ];
    }
}
