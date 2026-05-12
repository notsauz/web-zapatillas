<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('sneakers', function (Blueprint $table) {
            $table->string('color_es')->nullable()->after('color');
            $table->string('color_en')->nullable()->after('color_es');
            $table->text('description_es')->nullable()->after('description');
            $table->text('description_en')->nullable()->after('description_es');
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->text('description_es')->nullable()->after('description');
            $table->text('description_en')->nullable()->after('description_es');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('sneakers', function (Blueprint $table) {
            $table->dropColumn(['color_es', 'color_en', 'description_es', 'description_en']);
        });

        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn(['description_es', 'description_en']);
        });
    }
};
