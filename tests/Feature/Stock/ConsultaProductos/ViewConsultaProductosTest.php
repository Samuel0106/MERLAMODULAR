<?php
namespace Tests\Feature\Stock\ConsultaProductos;

use Tests\TestCase;
use App\Models\User;
use Tests\DuskTestCase;
use App\Models\Producto;
use App\Models\Categoria;
use Laravel\Dusk\Browser;

use Tests\Helpers\TestHelpers;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewConsultaProductosTest extends DuskTestCase
{
    use TestHelpers; 
    private User $admin;
    
    protected function setUp(): void {
        parent::setUp();
        //$this->artisan("db:seed");

        $this->admin = $this->createUser("admin");
    }


    public function test_consultar_productos_returns_a_succesful_response()
    {     
        $response = $this->actingAs($this->admin)->get('/productos');
        $response->assertStatus(200);
    }

    public function test_consultar_productos_contains_regresar_button() 
    {
        $response = $this->actingAs($this->admin)->get('/productos');
        $response->assertSee('Regresar');   
    }
    public function test_consultar_productos_regresar_button_redirects_successfully() 
    {
        $this->browse(function (Browser $browser) {
            $this->verifyLinkRedirection($browser, $this->admin, "/productos", "Regresar", "/inventarios");
        });
    } 


    public function test_consultar_productos_shows_data_by_categoria()
    {
        $this->browse(function (Browser $browser) {
            Producto::truncate();
            for ($i = 1; $i <= Categoria::count(); $i++) {
                    Producto::factory()->times(10)->create([
                        'categoria_id' => $i,
                    ]);
                $this->verifyFilterProductsByCategoria($browser, $this->admin, $i);
            }
            //Producto::truncate();
        });
    }   
   public function test_consultar_productos_shows_data_by_categoria_that_was_soft_deleted()
    {
        $this->browse(function (Browser $browser) {
            Producto::truncate();
            for ($i = 1; $i <= Categoria::count(); $i++) {
                    Producto::factory()->times(10)->create([
                        'categoria_id' => $i,
                        'existencias' => 0,
                    ]);
                    Producto::all()->map(function($producto){{
                        $producto->delete();
                    }});
                $this->verifyFilterProductsSoftDeletedByCategoria($browser, $this->admin, $i);
            }
            Producto::truncate();
    });
    }

    public function test_consultar_productos_borrar_button_erases_succesfully_on_all_categories()
    {
        $this->browse(function (Browser $browser) {
            Producto::truncate();
            for ($i = 1; $i <= Categoria::count(); $i++) {
                    Producto::factory()->times(10)->create([
                        'categoria_id' => $i,
                        'existencias' => 0,
                    ]);
                $this->verifyBorrarButtonInProductosSoftDeletesSuccessfully($browser, $this->admin, $i);
            }
            Producto::truncate();
    });
    }

}
