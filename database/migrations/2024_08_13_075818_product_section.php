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
        Schema::create('product_section', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("title");
            $table->text("description")->nullable();

            $table->foreignUuid('template_id')->constrained(table: "templates", column: "id")->onDelete("cascade")
                ->onUpdate("cascade");
            $table->unique(array("template_id", "deleted_at"));
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_section', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::dropIfExists('product_section');
    }
};
