<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('novels', function (Blueprint $table) {
        $table->softDeletes(); // ← これを追加
    });
}

public function down(): void
{
    Schema::table('novels', function (Blueprint $table) {
        $table->dropSoftDeletes(); // ← これを追加
    });
}
};
