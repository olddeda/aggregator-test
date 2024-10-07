<?php

namespace App\Http\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;

class Paginator extends LengthAwarePaginator
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'total' => $this->total(),
            'pages' => $this->lastPage(),
            'current_page' => $this->currentPage(),
            'per_page' => $this->perPage(),
            'first_page' => 1,
            'last_page' => $this->lastPage(),
        ];
    }
}
