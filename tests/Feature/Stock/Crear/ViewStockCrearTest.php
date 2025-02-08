<?php

namespace Tests\Feature\Stock\Crear;

use Tests\TestCase;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Helpers\TestHelpers;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewStockCrearTest extends DuskTestCase
{
    use TestHelpers; 
    private User $admin;
    
    protected function setUp(): void {
        parent::setUp();
        //$this->artisan("db:seed");

        $this->admin = $this->createUser("admin");
    }


    public function test_crear_productos_returns_a_succesful_response()
    {
        
        $response = $this->actingAs($this->admin)->get('/productos/create');
        $response->assertStatus(200);
    }


    public function test_crear_productos_form_contains_nombre()
    {
        
        $response = $this->actingAs($this->admin)->get('/productos/create');
        $response->assertStatus(200);
        //$response->assertSee("Nombre del        Producto:");
    }
    public function test_crear_productos_form_contains_unidad()
    {
        
        $response = $this->actingAs($this->admin)->get('/productos/create');
        $response->assertStatus(200);
        $response->assertSee("Unidad");
    }
    public function test_crear_productos_form_contains_stock_minimo()
    {
        
        $response = $this->actingAs($this->admin)->get('/productos/create');
        $response->assertStatus(200);
        $response->assertSee("Stock");
    }
    public function test_crear_productos_form_contains_categoria()
    {
        $response = $this->actingAs($this->admin)->get('/productos/create');
        $response->assertStatus(200);
        $response->assertSee("Categoría:");
    }

    public function test_crear_productos_regresar_button_redirects_successfully() 
    {
        $this->browse(function (Browser $browser) {
            $this->verifyLinkRedirection($browser, $this->admin, "/productos/create", "regresar", "/inventarios");
        });
    }
}
