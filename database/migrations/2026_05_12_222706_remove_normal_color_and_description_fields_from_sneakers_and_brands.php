<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sneakers', function (Blueprint $table) {
            $table->dropColumn(['color', 'description']);
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sneakers', function (Blueprint $table) {
            $table->string('color')->nullable()->after('sizes');
            $table->text('description')->nullable()->after('color_en');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->text('description')->nullable()->after('name');
        });
    }
};
