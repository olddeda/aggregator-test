<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_to_categories', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('news_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();

            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->onDelete('cascade');

            $table->foreign('category_id')
                ->references('id')
                ->on('news_categories')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_to_categories');
    }
};
