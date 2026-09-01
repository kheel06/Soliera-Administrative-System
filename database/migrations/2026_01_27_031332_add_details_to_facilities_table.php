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
        Schema::table('facilities', function (Blueprint $table) {
            if (!Schema::hasColumn('facilities', 'amenities')) {
                $table->json('amenities')->nullable(); // WiFi, Projector, etc.
            }
            if (!Schema::hasColumn('facilities', 'pricing_type')) {
                $table->string('pricing_type')->default('Free'); // Free, Hourly, Daily
            }
            if (!Schema::hasColumn('facilities', 'price_per_hour')) {
                $table->decimal('price_per_hour', 8, 2)->default(0);
            }
            if (!Schema::hasColumn('facilities', 'is_bookable')) {
                $table->boolean('is_bookable')->default(true);
            }
            if (!Schema::hasColumn('facilities', 'image_path')) {
                $table->string('image_path')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropColumn(['amenities', 'pricing_type', 'price_per_hour', 'is_bookable', 'image_path']);
        });
    }
};
