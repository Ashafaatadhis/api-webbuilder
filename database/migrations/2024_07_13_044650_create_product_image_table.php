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
        Schema::create('product_image', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("url");


            $table->foreignUuid('product_id')->constrained(table: "products", column: "id")->onDelete("cascade")
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
        Schema::table('product_image', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('product_image');
    }
};
