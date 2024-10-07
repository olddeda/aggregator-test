<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modules\Auth\Enums\AuthCodeStatus;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('auth_codes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('login', 20);
            $table->string('code', 10);

            $table->enum('status', AuthCodeStatus::values());

            $table->timestamp('available_at')->nullable();
            $table->timestamps();

            $table->index(['login', 'code']);
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_codes');
    }
};
