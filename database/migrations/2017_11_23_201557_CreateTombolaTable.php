<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTombolaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function ($table) {
            $table->integer('id', true, true);
            $table->string('uid', 8)->unique();
            $table->string('email')->unique();
            $table->boolean('is_sorted')->default(0);
        });

        DB::table('tickets')->insert([
            ['uid' => 'HQ7BKXVS', 'email' => '__hq7bkxvs__@mailinator.com'],
            ['uid' => '4HFDCNNX', 'email' => '__4hfdcnnx__@mailinator.com'],
            ['uid' => 'YKP4Q5WK', 'email' => '__ykp4q5wk__@mailinator.com'],
            ['uid' => 'AN7FGPAD', 'email' => '__an7fgpad__@mailinator.com'],
            ['uid' => 'PUBWKPJD', 'email' => '__pubwkpjd__@mailinator.com'],
            ['uid' => 'XRVX9V8U', 'email' => '__xrvx9v8u__@mailinator.com'],
            ['uid' => 'F7PGHR6Q', 'email' => '__f7pghr6q__@mailinator.com'],
            ['uid' => '67EXCCPB', 'email' => '__67exccpb__@mailinator.com'],
            ['uid' => 'YMSFDBDE', 'email' => '__ymsfdbde__@mailinator.com'],
            ['uid' => 'VMXDD38I', 'email' => '__vmxdd38i__@mailinator.com'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
