<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            //ID for BDD
            $table->id();
            //Image for BDD
            $table->string('path_image')->nullable();
            //Product's Code
            $table->string('code_product')->unique();
            //Product's name
            $table->string('name_product',200);
            //Product's Price
            $table->decimal('price', 8, 2);
            //Product's Description
            $table->string('description')->nullable();
            //Product's Stock
            $table->string('stock');
            //Product's State
            $table->boolean('state')->default(true);


           //Un producto puede estar varios usuarios y 
           //Un usuario puede tener muchos productos
           $table->unsignedBigInteger('user_id');
           $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');                     
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
