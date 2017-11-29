<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes', function ($table) {
            $table->integer('id', true, true);
            $table->string('description');
            $table->string('winner')->unique()->nullable();
        });

        DB::table('prizes')->insert([
            ['description' => 'Prize #1'],
            ['description' => 'Prize #2'],
            ['description' => 'Prize #3'],
            ['description' => 'Prize #4'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prizes');
    }
}
