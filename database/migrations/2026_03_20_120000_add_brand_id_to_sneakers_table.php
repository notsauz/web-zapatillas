<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sneakers', function (Blueprint $table) {
            if (!Schema::hasColumn('sneakers', 'brand_id')) {
                $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        
    }
};
