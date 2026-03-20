<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZapatillasTable extends Migration
{
    public function up()
    {
        Schema::create('zapatillas', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->foreignId('modelo_id')->constrained('modelos')->onDelete('cascade');
            $table->string('nombre');
            $table->decimal('precio', 10, 2);
            $table->string('imagen_url')->nullable();
            $table->boolean('tendencia')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('zapatillas');
    }
}
