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
        Schema::table('setup_packages', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('id');
            $table->string('category')->nullable()->after('price');
            $table->string('status')->default('Active')->after('category');
            $table->string('estimation')->nullable()->after('status');
            $table->string('platforms')->nullable()->after('estimation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('setup_packages', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'category', 'status', 'estimation', 'platforms']);
        });
    }
};
