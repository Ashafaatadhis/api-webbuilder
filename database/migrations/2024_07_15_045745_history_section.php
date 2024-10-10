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
        Schema::create('history_section', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("title");
            $table->text("paragraph1")->nullable();
            $table->text("paragraph2")->nullable();
            $table->string("image")->nullable();
            $table->foreignUuid('templateLink_id')->unique()->constrained(table: "template_link", column: "id")->onDelete("cascade")
                ->onUpdate("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('history_section');
    }
};
