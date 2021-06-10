<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccessRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get faker user model
     * 
     * @param   boolean $allowed
     * @return  \App\Models\User
     */
    protected function getUser($allowed = false)
    {
        $user = User::factory()->create();
        if ($allowed) {
            $permission = Permission::where('slug', 'access_role')->first();
            $role = Role::find(2);
            $role->permissions()->sync([$permission->id]);
            $user->role_id = $role->id;
        }

        return $user;  
    }

    /**
     * A basic feature test index access allowed.
     *
     * @return void
     */
    public function test_access_allowed()
    {
        $user = $this->getUser(true);

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

    public function test_store_roles()
    {
        $user = $this->getUser(true);
        $role = Role::factory()->make();
        // 필수 입력 체크
        $response = $this->actingAs($user)->post('/roles', [
        ]);
        $response->assertSessionHasErrors(['name', 'slug']);

        $response = $this->post('/roles', [
            'name' => $role->name,
        ]);
        $response->assertSessionHasErrors(['slug']);

        // Role 등록
        $response = $this->actingAs($user)->post('/roles', [
            'name' => $role->name,
            'slug' => $role->slug,
        ]);
        $response->assertSessionHasNoErrors();

        $this->assertEquals($role->slug, Role::orderBy('id', 'desc')->first()->slug);
        
    }

    public function test_update_role()
    {
        $user = $this->getUser(true);
        $role = Role::factory()->create();

        // 필수 입력 체크
        $response = $this->actingAs($user)->put('/roles/'.$role->id, [
        ]);
        $response->assertSessionHasErrors(['name', 'slug']);

        $response = $this->put('/roles/'.$role->id, [
            'name' => $role->name,
            'slug' => 'tester2',
        ]);
        $response->assertSessionHasNoErrors();

        $this->assertEquals('tester2', $role->refresh()->slug);
    }

    public function test_delete_role()
    {
        $user = $this->getUser(true);

        $role = Role::factory()->create();

        $response = $this->actingAs($user)->delete('/roles/'.$role->id);
        $this->assertNotNull($role->refresh());
    }

    public function test_access_denied()
    {
        $user = $this->getUser();

        // access roles index
        $response = $this->actingAs($user)->get('/roles');
        $response->assertStatus(403);

        // access roles create
        $response = $this->get('/roles/create');
        $response->assertStatus(403);

        // access roles store
        $response = $this->post('/roles', []);
        $response->assertStatus(403);
        
        // access roles show
        $response = $this->get('/roles/1');
        $response->assertStatus(403);

        // access roles update
        $response = $this->put('/roles/1');
        $response->assertStatus(403);

        // access roles delete
        $response = $this->delete('/roles/1');
        $response->assertStatus(403);
    }
}
