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
        Schema::create('store_image', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("url");
            $table->foreignUuid('store_id')->constrained(table: "stores", column: "id")->onDelete("cascade")
                ->onUpdate("cascade");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_image', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('store_image');
    }
};
