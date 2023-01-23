<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('feedback', function (Blueprint $table) {
        // Relación
        // Un producto puede tener muchos feedback y a un feedback le pertenece un producto            
            $table->unsignedBigInteger('product_id')->after('id');

            $table->foreign('product_id')
                   ->references('id')
                   ->on('products')
                   ->onDelete('cascade')
                   ->onUpdate('cascade');
        });
    }


    public function down()
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
    }
};
