<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_is_admin()
    {
        $user = User::factory()->create();
        $user->role_id = 1;
    
        $this->assertTrue($user->isAdmin());
    }

    public function test_is_not_admin()
    {
        $user = User::factory()->create();
        $this->assertFalse($user->isAdmin());
    }

    public function test_access_role_allowed()
    {
        $user = User::factory()->create();
        $user->role_id = 1;
        // access roles index
        $response = $this->actingAs($user)->get('/roles');
        $response->assertStatus(200);

        // access roles create
        $response = $this->get('/roles/create');
        $response->assertStatus(200);
        
        // access roles show
        $response = $this->get('/roles/1');
        $response->assertStatus(200);

    }
}
