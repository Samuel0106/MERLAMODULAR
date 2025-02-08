<?php

namespace Tests\Feature\Stock\ConsultaCategorias;

use Tests\TestCase;
use App\Models\User;
use Tests\DuskTestCase;
use App\Models\Producto;
use App\Models\Categoria;
use Laravel\Dusk\Browser;
use Tests\Helpers\TestHelpers;
use Facade\Ignition\DumpRecorder\Dump;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class ViewConsultaCategoriasTest extends DuskTestCase
{
    use TestHelpers; 
    private User $admin;
    
    protected function setUp(): void {
        parent::setUp();
        //$this->artisan("db:seed");

        $this->admin = $this->createUser("admin");
    }


    public function test_consultar_categorias_returns_a_succesful_response()
    {     
        $response = $this->actingAs($this->admin)->get('/categorias');
        $response->assertStatus(200);
    }

    public function test_consultar_categorias_contains_regresar_button() 
    {
        $response = $this->actingAs($this->admin)->get('/categorias');
        $response->assertSee('Regresar');   
    }
    public function test_consultar_categorias_regresar_button_redirects_successfully() 
    {
        $this->browse(function (Browser $browser) {
            $this->verifyLinkRedirection($browser, $this->admin, "/categorias", "Regresar", "/inventarios");
        });
    } 

    public function test_consultar_categorias_shows_categorias()
    {
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");
        $this->browse(function (Browser $browser) {
            for ($i = 1; $i <= Categoria::count(); $i++) {
                $this->verifyCategorias($browser, $this->admin, $i);
            }
        });
    }
    public function test_consultar_categorias_destroy_categorias()
    {
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");
        $numeroCategorias = Categoria::count();
        
        
        for ($i = 1; $i <= $numeroCategorias; $i++) {
            $categoria = Categoria::find($i);
            $response = $this->actingAs($this->admin)->delete('categorias/' . $i);
            $response->assertStatus(status: 302);
            $this->assertDatabaseMissing('categorias', [
                'nombre_cat' => $categoria->nombre_cat,
            ]);
        } 
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");
    }
    public function test_consultar_categorias_boton_destroys_categoria_succesfully(){
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");
        $this->browse(function (Browser $browser) {
            $this->verifyBorrarButtonDeletesSuccessfully($browser, $this->admin, Categoria::class, "categorias", "nombre_cat", "/categorias", "#boton");
        });
        $this->truncateTableWithForeignKeys(Categoria::class, "CategoriaSeeder");
    }
}
       