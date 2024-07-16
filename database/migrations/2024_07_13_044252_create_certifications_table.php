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
        Schema::create('certifications', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->string("issuer");

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
        Schema::table('certifications', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('certifications');
    }
};
