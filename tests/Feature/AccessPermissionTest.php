<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccessPermissionTest extends TestCase
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
            $permission = Permission::where('slug', 'access_permission')->first();
            $role = Role::find(2);
            $role->permissions()->sync([$permission->id]);
            $user->role_id = $role->id;
        }

        return $user;  
    }

    public function test_access_denied()
    {
        $user = $this->getUser();

        // access permissions index
        $response = $this->actingAs($user)->get('/permissions');
        $response->assertStatus(403);

        // access permissions create
        $response = $this->get('/permissions/create');
        $response->assertStatus(403);

        // access permissions store
        $response = $this->post('/permissions', []);
        $response->assertStatus(403);
        
        // access permissions show
        $response = $this->get('/permissions/1');
        $response->assertStatus(403);

        // access permissions update
        $response = $this->put('/permissions/1');
        $response->assertStatus(403);

        // access permissions delete
        $response = $this->delete('/permissions/1');
        $response->assertStatus(403);
    }

    /**
     * A basic feature test index access allowed.
     *
     * @return void
     */
    public function test_access_allowed()
    {
        $user = $this->getUser(true);

        // access permissions index
        $response = $this->actingAs($user)->get('/permissions');
        $response->assertStatus(200);

        // access permissions create
        $response = $this->get('/permissions/create');
        $response->assertStatus(200);
        
        // access permissions show
        $response = $this->get('/permissions/1');
        $response->assertStatus(200);

    }

    public function test_store_permissions()
    {
        $user = $this->getUser(true);
        $permission = Permission::factory()->make();
        // 필수 입력 체크
        $response = $this->actingAs($user)->post('/permissions', [
        ]);
        $response->assertSessionHasErrors(['name', 'slug']);

        $response = $this->post('/permissions', [
            'name' => $permission->name,
        ]);
        $response->assertSessionHasErrors(['slug']);

        // Role 등록
        $response = $this->actingAs($user)->post('/permissions', [
            'name' => $permission->name,
            'slug' => $permission->slug,
        ]);
        $response->assertSessionHasNoErrors();
        
        $this->assertEquals($permission->slug, Permission::orderBy('id', 'desc')->first()->slug);
        
    }

    public function test_update_permission()
    {
        $user = $this->getUser(true);
        $permission = Permission::factory()->create();

        // 필수 입력 체크
        $response = $this->actingAs($user)->put('/permissions/'.$permission->id, [
        ]);
        $response->assertSessionHasErrors(['name', 'slug']);

        $response = $this->put('/permissions/'.$permission->id, [
            'name' => $permission->name,
            'slug' => 'access_tester',
        ]);
        $response->assertSessionHasNoErrors();

        $this->assertEquals('access_tester', $permission->refresh()->slug);
    }

    public function test_delete_permission()
    {
        $user = $this->getUser(true);

        $permission = Permission::factory()->create();

        $response = $this->actingAs($user)->delete('/permissions/'.$permission->id);
        $this->assertNotNull($permission->refresh());
    }
}
