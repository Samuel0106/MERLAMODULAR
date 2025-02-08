<?php

namespace Tests\Feature\Stock\ConsultaProductos;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\TestHelpers;

class AuthConsultaProductosTest extends TestCase
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

    public function test_authenticated_admin_can_access_consultar_productos()
    {
        
        $response = $this->actingAs($this->admin)->get('productos');
        $response->assertStatus(200);
    }
    public function test_authenticated_user_cannot_access_consultar_productos()
    {
        
        $response = $this->actingAs($this->user)->get('productos');
        $response->assertStatus(403);
    }
    public function test_unauthenticated_user_cannot_access_consultar_productos()
    {
        
        $response = $this->get('productos');

        $response->assertStatus(302);
        $response->assertRedirect(uri: 'login');
    }
}
