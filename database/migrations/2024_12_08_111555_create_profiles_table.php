<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('stage_name')->unique()->nullable();
            $table->string('photo')->nullable();
            $table->json('genre')->nullable();
            $table->string('preferred_performance_location')->nullable();
            $table->longtext('bio')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->json('address')->nullable();
            $table->json('special_skills')->nullable();
            $table->json('interests')->nullable();
            $table->json('social_media')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
