<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\Sneaker;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$results = Sneaker::where(function($q) {
    $q->where('color_es', 'like', '%color%')
      ->orWhere('color_en', 'like', '%color%');
})->get();

echo "Sneakers with 'color' in either color_es or color_en:\n";
foreach ($results as $sneaker) {
    echo "- {$sneaker->name} (SKU: {$sneaker->sku}) ES='" . ($sneaker->color_es ?? '') . "' EN='" . ($sneaker->color_en ?? '') . "'\n";
}
