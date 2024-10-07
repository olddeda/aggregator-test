<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

use App\Modules\News\Models\NewsSource;
use App\Modules\News\Enums\NewsSourceType;
use App\Modules\News\Enums\NewsSourceStatus;

return new class extends Migration
{
    public function up(): void
    {
        NewsSource::query()->insert([
            'type' => NewsSourceType::RSS,
            'status' => NewsSourceStatus::ENABLED,
            'url' => 'https://www.iphones.ru/feed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('news_sources')->truncate();
    }
};
