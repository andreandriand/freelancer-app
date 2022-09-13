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
        Schema::table('experience_users', function (Blueprint $table) {
            $table->foreign('user_detail_id', 'fk_experience_users_to_detail_users')->references('user_id')->on('detail_users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('experience_users', function (Blueprint $table) {
            $table->dropForeign('fk_experience_users_to_detail_users');
        });
    }
};
