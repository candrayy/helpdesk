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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('kd_role');
            $table->string('role_name');
            $table->timestamps();
        });

        DB::table('roles')->insert([
            [
                'kd_role' => 'K1',
                'role_name' => 'Admin'
            ],
            [
                'kd_role' => 'K2',
                'role_name' => 'User'
            ],
            [
                'kd_role' => 'K3',
                'role_name' => 'Technician'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
