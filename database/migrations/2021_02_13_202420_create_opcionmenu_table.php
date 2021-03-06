<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpcionmenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opcionmenu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 200);
            $table->string('link', 200);
            $table->string('icono', 200)->nullable();
            $table->integer('orden')->default(0);
            $table->unsignedInteger('grupomenu_id')->default(0);
            $table->foreign('grupomenu_id', 'fk_opcionmenu_grupomenu')
                ->references('id')
                ->on('grupomenu')
                ->onDelete('restrict')
                ->onUpdate('restrict');
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
        Schema::dropIfExists('opcionmenu');
    }
}
