<?php

namespace Tests\Feature\Stock\CrearCategoria;

use Tests\TestCase;
use App\Models\User;
use Tests\Helpers\TestHelpers;
class AuthCrearCategoriaTest extends TestCase
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

    public function test_authenticated_admin_can_access_crear_categorias()
    {
        
        $response = $this->actingAs($this->admin)->get('categorias/create');
        $response->assertStatus(200);
    }
    public function test_authenticated_user_cannot_access_crear_categorias()
    {
        
        $response = $this->actingAs($this->user)->get('categorias/create');
        $response->assertStatus(403);
    }
    public function test_unauthenticated_user_cannot_access_crear_categorias()
    {
        
        $response = $this->get('categorias/create');

        $response->assertStatus(302);
        $response->assertRedirect(uri: 'login');
    }
}
