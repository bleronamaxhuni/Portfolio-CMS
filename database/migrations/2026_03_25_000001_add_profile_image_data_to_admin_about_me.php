<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_about_me', function (Blueprint $table) {
            $table->longText('profile_image_data')->nullable();
            $table->string('profile_image_mime')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('admin_about_me', function (Blueprint $table) {
            $table->dropColumn(['profile_image_data', 'profile_image_mime']);
        });
    }
};

