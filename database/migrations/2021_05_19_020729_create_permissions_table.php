<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        $createdAt = now();
        DB::table('permissions')->insert([
            [
                'name' => 'Access Dashboard',
                'slug' => 'access_dashboard',
                'created_at' => $createdAt
            ],
            [
                'name' => 'Access Role',
                'slug' => 'access_role',
                'created_at' => $createdAt
            ],
            [
                'name' => 'Access Permission',
                'slug' => 'access_permission',
                'created_at' => $createdAt
            ],
            [
                'name' => 'Access Contact',
                'slug' => 'access_contact',
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
        Schema::dropIfExists('permissions');
    }
}
