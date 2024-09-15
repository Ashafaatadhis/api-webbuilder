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
        Schema::create('template_category', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->string("slug");
            $table->unique(array("name", "deleted_at"));
            $table->unique(array("slug", "deleted_at"));
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('template_category', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('template_category');
    }
};
