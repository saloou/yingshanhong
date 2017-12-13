<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     * 运行 这个migrations
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->text('pName');
            $table->float('oPrice');
            $table->float('nPrice');
            $table->bigInteger('stock');
            $table->text('description');
            $table->string('photo',200);
            $table->integer('categoryId')->unsigned();
            $table->foreign('categoryId')->references('id')->on('product_categories');
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
        Schema::dropIfExists('products');
    }
}
