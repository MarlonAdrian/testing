<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->boolean('received')->default(TRUE);//1=received, 0=noreceived
            $table->integer('amount')->default(1);//by default will be 1  

           //Un producto puede estar varios usuarios y 
           //Un usuario puede tener muchos productos
           $table->unsignedBigInteger('user_id');
           $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');    


           //Un producto puede estar varios pedidos y 
           //Un pedido puede tener muchos productos
           $table->unsignedBigInteger('product_id');
           $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');    

  
           $table->timestamps();
        });
    }


    
    public function down()
    {
        Schema::dropIfExists('product_orders');
    }
};
