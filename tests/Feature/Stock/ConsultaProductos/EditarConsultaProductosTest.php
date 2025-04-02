<?php

namespace Tests\Feature\Stock\ConsultaProductos;
use Tests\TestCase;
use App\Models\User;
use App\Models\Status;
use Tests\DuskTestCase;
use App\Models\Producto;
use App\Models\Categoria;
use Laravel\Dusk\Browser;

use Tests\Helpers\TestHelpers;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditarConsultaProductosTest extends DuskTestCase
{
    use TestHelpers; 
    private User $admin;
    private User $user;
    
    protected function setUp(): void {
        parent::setUp();
        //$this->artisan("db:seed");

        $this->admin = $this->createUser("admin");
        $this->user = $this->createUser("usuario");
    }


    public function test_editar_productos_returns_a_succesful_response_as_admin()
    {     
        $response = $this->actingAs($this->admin)->get('/productos/1/edit');
        $response->assertStatus(200);
    }
    public function test_editar_productos_returns_unauthorized_response_as_user()
    {     
        $response = $this->actingAs($this->user)->get('/productos/1/edit');
        $response->assertStatus(403);
    }


    public function test_editar_productos_contains_regresar_button() 
    {
        $response = $this->actingAs($this->admin)->get('/productos/1/edit');
        $response->assertSee('Regresar');   
    }
    public function test_editar_productos_regresar_button_redirects_successfully() 
    {
        $this->browse(function (Browser $browser) {
            $this->verifyLinkRedirection($browser, $this->admin, '/productos/1/edit', "Regresar", '/productos');
        });
    } 
    public function test_editar_productos_cancelar_button_redirects_successfully() 
    {
        $this->browse(function (Browser $browser) {
            $this->verifyLinkRedirection($browser, $this->admin, '/productos/1/edit', "Cancelar", '/productos');
        });
    } 

    
    public function test_editar_productos_guardar_button_redirects_successfully() 
    {
        $this->browse(function (Browser $browser) {
            $this->verifyButtonRedirectsSuccessfully($browser, $this->admin, '/productos/1/edit', "Guardar", '/productos');
        });
    } 

    public function test_editar_productos_update_validation_error_redirects_back_to_form(){
        $producto = Producto::factory()->create();

        $response = $this->actingAs($this->admin)->put('productos/' . $producto->id, [
            'nombre_producto' => '',
            'unidad' => 'Piezas',
            'stock_minimo' => '',
            'id_categoria' => '1',
            'area' => 'DN00', 
            'subarea' => 'DN00', 
            'existencias' => '3', 
            'photo_prod' => 'iconProduct.png'
        ]);
        $response->assertStatus( status: 302);
        $response->assertInValid(['nombre_producto','stock_minimo']);
    }
    public function test_editar_productos_update_works_as_admin(){
        $producto = Producto::factory()->create();

        $response = $this->actingAs($this->admin)->put('productos/' . $producto->id, [
            'nombre_producto' => 'Nuevo Nombre',
            'unidad' => 'Piezas',
            'stock_minimo' => '123',
            'id_categoria' => '1',
            'area' => 'DN00', 
            'subarea' => 'DN00', 
            'existencias' => '3', 
            'photo_prod' => 'iconProduct.png'
        ]);
        $response->assertStatus( status: 302);
        $response->assertValid(['nombre_producto','stock_minimo']);
    }
    public function test_editar_productos_update_doesnt_works_as_user(){
        $producto = Producto::factory()->create();

        $response = $this->actingAs($this->user)->put('productos/' . $producto->id, [
            'nombre_producto' => 'Nuevo Nombre',
            'unidad' => 'Piezas',
            'stock_minimo' => '123',
            'id_categoria' => '1',
            'area' => 'DN00', 
            'subarea' => 'DN00', 
            'existencias' => '3', 
            'photo_prod' => 'iconProduct.png'
        ]);
        $response->assertStatus( status: 403);
    }


    //to do, check if image upload works.
    /* public function test_avatars_can_be_uploaded()
    {
        Storage::fake('avatars');
 
        $file = UploadedFile::fake()->image('avatar.jpg');
 
        $response = $this->post('/avatar', [
            'avatar' => $file,
        ]);
 
        Storage::disk('avatars')->file_exists();
    } */
}
