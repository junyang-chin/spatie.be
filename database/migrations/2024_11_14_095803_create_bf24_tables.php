<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bf24_questions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('day');
            $table->text('question');
            $table->text('answer');
        });

        Schema::create('bf24_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class);
            $table->tinyInteger('day');
            $table->string('reward');

            $table->timestamps();

            $table->unique(['user_id', 'day']);
        });
    }
};
