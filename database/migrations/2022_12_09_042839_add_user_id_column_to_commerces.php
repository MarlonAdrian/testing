<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('commerces', function (Blueprint $table) {
        // Relación
        // Un usuario puede tener muchos negocios y un negocio le pertenece a un usuario
            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id')
                   ->references('id')
                   ->on('users')
                   ->onDelete('cascade')
                   ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('commerces', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
