<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
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
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        $createdAt = now();

        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Administrator',
                'slug' => 'admin',
                'created_at' => $createdAt
            ],
            [
                'id' => 2,
                'name' => 'User',
                'slug' => 'user',
                'created_at' => $createdAt
            ],
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
}
