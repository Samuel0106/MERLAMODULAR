<?php

namespace Tests\Feature\Stock\ConsultaCategorias;

use App\Models\User;
use Tests\DuskTestCase;
use App\Models\Categoria;
use Laravel\Dusk\Browser;
use Tests\Helpers\TestHelpers;

class EditarConsultaCategoriasTest extends DuskTestCase
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

    public function test_editar_categorias_returns_a_succesful_response_as_admin()
    {     
        $response = $this->actingAs($this->admin)->get('/categorias/1/edit');
        $response->assertStatus(200);
    }
    public function test_editar_categorias_returns_unauthorized_response_as_user()
    {     
        $response = $this->actingAs($this->user)->get('/categorias/1/edit');
        $response->assertStatus(403);
    }

    public function test_consultar_categorias_contains_regresar_button() 
    {
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");
        $response = $this->actingAs($this->admin)->get('/categorias/1/edit');
        $response->assertSee('Regresar');   
    }
    public function test_consultar_categorias_regresar_button_redirects_successfully() 
    {
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");
        $this->browse(function (Browser $browser) {
            $this->verifyLinkRedirection($browser, $this->admin, "/categorias/1/edit", "Regresar", "/categorias");
        });
    } 
    public function test_consultar_categorias_contains_cancelar_button() 
    {
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");
        $response = $this->actingAs($this->admin)->get('/categorias/1/edit');
        $response->assertSee('Cancelar');   
    }
    public function test_consultar_categorias_cancelar_button_redirects_successfully() 
    {
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");
        $this->browse(function (Browser $browser) {
            $this->verifyLinkRedirection($browser, $this->admin, "/categorias/1/edit", "Cancelar", "/categorias");
        });
    } 


    public function test_editar_categorias_works(){
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");

        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->admin)
            ->visit('/categorias/1/edit')
            ->type("nombre_cat", 'NombreNuevo123')
            ->press("Guardar")
            ->pause(1000)
            ->assertSee("NombreNuevo123");
        });
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");
       
        
    }

    public function test_editar_categorias_update_doesnt_works_as_admin(){
        $producto = Categoria::factory()->create();

        $response = $this->actingAs($this->user)->put('categorias/' . $producto->id, [
            'nombre_cat' => 'Nuevo Nombre',
        ]);
        $response->assertStatus( status: 403);
        $response->assertValid(['nombre_cat']);
    }
    public function test_editar_categorias_update_works_as_admin(){
        $producto = Categoria::factory()->create();

        $response = $this->actingAs($this->admin)->put('categorias/' . $producto->id, [
            'nombre_cat' => 'Nuevo Nombre',
        ]);
        $response->assertStatus( status: 302);
        $response->assertValid(['nombre_cat']);
    }
    public function test_editar_categorias_validation_error_works(){
        $instancia = Categoria::factory()->create();

        $response = $this->actingAs($this->admin)->put('categorias/' . $instancia->id, [
            'nombre_cat' => '',
        ]);
        $response->assertInValid(['nombre_cat']);
    }

}
