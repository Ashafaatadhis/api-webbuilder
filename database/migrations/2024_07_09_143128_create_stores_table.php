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
        Schema::create('stores', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->string("slug");
            $table->string("description")->nullable();
            $table->string("instagram")->nullable();
            $table->string("facebook")->nullable();
            $table->string("whatsapp")->nullable();
            $table->string("logo");
            $table->text("gmaps");
            $table->text("location");
            $table->foreignUuid('user_id')->constrained(table: "users", column: "id")->onDelete("cascade")
                ->onUpdate("cascade");
            $table->foreignUuid('storeCategory_id')->constrained(table: "store_category", column: "id")->onDelete("cascade")
                ->onUpdate("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('stores');
    }
};
