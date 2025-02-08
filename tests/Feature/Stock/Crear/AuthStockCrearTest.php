<?php

namespace Tests\Feature\Stock\Crear;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\TestHelpers;

class AuthStockCrearTest extends TestCase
{
    //use RefreshDatabase;
    use TestHelpers; 
    private User $admin;
    private User $user;
    
    protected function setUp(): void {
        parent::setUp();
        //$this->artisan("db:seed");

        $this->admin = $this->createUser("admin");
        $this->user = $this->createUser("user");
        
    }

    public function test_authenticated_admin_can_access_crear_productos()
    {
        
        $response = $this->actingAs($this->admin)->get('/productos/create');
        $response->assertStatus(200);
    }
    public function test_authenticated_user_cannot_access_crear_productos()
    {
        
        $response = $this->actingAs($this->user)->get('/productos/create');
        $response->assertStatus(403);
    }
    public function test_unauthenticated_user_cannot_access_crear_productos()
    {
        
        $response = $this->get('/productos/create');

        $response->assertStatus(302);
        $response->assertRedirect(uri: 'login');
    }
}
