<?php

namespace Tests\Feature\Stock\CrearCategoria;

use App\Models\User;
use Tests\DuskTestCase;
use App\Models\Categoria;
use Laravel\Dusk\Browser;
use Tests\Helpers\TestHelpers;

class ViewCrearCategoriaTest extends DuskTestCase
{
    use TestHelpers; 
    private User $admin;
    
    protected function setUp(): void {
        parent::setUp();
        //$this->artisan("db:seed");

        $this->admin = $this->createUser("admin");
    }


    public function test_crear_categorias_returns_a_succesful_response()
    {     
        $response = $this->actingAs($this->admin)->get('/categorias');
        $response->assertStatus(200);
    }


    public function test_crear_categorias_contains_regresar_button() 
    {
        $response = $this->actingAs($this->admin)->get('/categorias/create');
        $response->assertSee('Regresar');   
    }
    public function test_crear_categorias_contains_cancelar_button() 
    {
        $response = $this->actingAs($this->admin)->get('/categorias/create');
        $response->assertSee('Cancelar');   
    }
    public function test_crear_categorias_contains_Guardar_button() 
    {
        $response = $this->actingAs($this->admin)->get('/categorias/create');
        $response->assertSee('Guardar');   
    }


    public function test_crear_categorias_regresar_button_redirects_successfully() 
    {
        $this->browse(function (Browser $browser) {
            $this->verifyLinkRedirection($browser, $this->admin, "/categorias/create", "Regresar", "/inventarios");
        });
    } 

    public function test_crear_categorias_creates_categorias()
    {
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder", true);
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)->visit('/categorias/create')
            ->type("nombre_cat", 'NuevaCategoria')
            ->press("Guardar")
            ->pause(1000)
            ->assertSee("NuevaCategoria");
        });
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder", true);
    }
}
