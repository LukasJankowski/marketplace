<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(
            'accounts',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained();
                $table->string('salutation')->nullable();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('phone')->nullable();
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
}
