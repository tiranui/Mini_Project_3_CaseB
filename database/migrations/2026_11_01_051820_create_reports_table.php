<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::create('reports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->restrictOnDelete();
        $table->foreignId('area_id')->constrained()->restrictOnDelete();
        $table->string('title');
        $table->text('description');
        $table->decimal('latitude', 10, 7);
        $table->decimal('longitude', 10, 7);
        $table->dateTime('occurred_at');
        $table->string('status', 30)->default('menunggu_review')->index();
        $table->string('evidence_path')->nullable();
        $table->text('reviewer_note')->nullable();
        $table->string('forwarded_to')->nullable();
        $table->dateTime('forwarded_at')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
