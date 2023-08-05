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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('slug');
            $table->unsignedBigInteger('speaker_id');
            $table->string('address');
            $table->string('category');
            $table->text('description');
            $table->string('image')->nullable();
            $table->float('ticket_price');
            $table->integer('ticket_number');
            $table->integer('ticket_remaining');
            $table->float('longitude');
            $table->float('latitude');
            $table->dateTime('published_at')->nullable();
            $table->dateTime('date');
            $table->timestamps();
            $table->foreign('speaker_id')->references('id')->on('speakers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
