<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_users', function (Blueprint $table) {
            $table->id();
            // $table->integer('user_id')->nullable();
            $table->foreignId('user_id')->nullable()->index('fk_detail_users_to_users');
            $table->longText('photo')->nullable();
            $table->string('role')->nullable();
            $table->string('contact')->nullable();
            $table->longText('biography')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_users');
    }
};
