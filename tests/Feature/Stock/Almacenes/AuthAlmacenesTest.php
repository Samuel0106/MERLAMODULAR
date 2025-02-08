<?php

namespace Tests\Feature\Stock\Almacenes;

use Tests\TestCase;
use App\Models\User;
use Tests\Helpers\TestHelpers;

class AuthAlmacenesTest extends TestCase
{
    use TestHelpers; 
    private User $admin;
    private User $user;
    
    protected function setUp(): void {
        parent::setUp();
        //$this->artisan("db:seed");

        $this->admin = $this->createUser("admin");
        $this->user = $this->createUser("user");
        
    }

    public function test_authenticated_admin_can_access_almacenes()
    {
        ob_end_flush();
        ob_get_clean(); 
        $response = $this->actingAs($this->admin)->get('almacenes');
        $response->assertStatus(200);
    }
    public function test_authenticated_user_cannot_access_almacenes()
    {
        $response = $this->actingAs($this->user)->get('almacenes');
        $response->assertStatus(403);
    }
    public function test_unauthenticated_user_cannot_access_almacenes()
    {
        $response = $this->get('almacenes');

        $response->assertStatus(302);
        $response->assertRedirect(uri: 'login');
    }
}
