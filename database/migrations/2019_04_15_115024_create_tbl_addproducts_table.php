<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAddproductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_addproducts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_name');
            $table->string('product_type');
            $table->string('product_code');
            $table->integer('total_bag');
            $table->integer('weightperbag');
            $table->integer('total_weight');
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
        Schema::dropIfExists('tbl_addproducts');
    }
}
