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
        Schema::table('profiles', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('bio');
            $table->string('gender')->nullable()->after('date_of_birth');
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {});
    }
};
