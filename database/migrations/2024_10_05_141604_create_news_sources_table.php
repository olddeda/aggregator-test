<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modules\News\Enums\NewsSourceStatus;
use App\Modules\News\Enums\NewsSourceType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_sources', function (Blueprint $table) {
            $table->id();

            $table->enum('type', NewsSourceType::values());
            $table->enum('status', NewsSourceStatus::values());
            $table->string('url');

            $table->text('last_error')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_sources');
    }
};
