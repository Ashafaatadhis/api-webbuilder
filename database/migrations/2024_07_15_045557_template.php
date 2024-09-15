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
        Schema::create('templates', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("name");
            $table->foreignUuid('store_id')->constrained(table: "stores", column: "id")->onDelete("cascade")
                ->onUpdate("cascade");
            $table->foreignUuid('templateCategory_id')->constrained(table: "template_category", column: "id")->onDelete("cascade")
                ->onUpdate("cascade");

            $table->unique(array("templateCategory_id", "deleted_at"));
            $table->unique(array("store_id", "deleted_at", "name"));
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('templates', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('templates');
    }
};
