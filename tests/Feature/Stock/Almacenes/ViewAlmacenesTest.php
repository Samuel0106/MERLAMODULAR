<?php

namespace Tests\Feature\Stock\Almacenes;

use App\Models\Almacen;
use App\Models\User;
use Tests\DuskTestCase;
use App\Models\Categoria;
use Laravel\Dusk\Browser;
use Tests\Helpers\TestHelpers;

class ViewAlmacenesTest extends DuskTestCase
{
    use TestHelpers; 
    private User $admin;
    
    protected function setUp(): void {
        parent::setUp();
        //$this->artisan("db:seed");

        $this->admin = $this->createUser("admin");
    }
    public function test_almacenes_contains_regresar_button() 
    {
        $this->browse(function (Browser $browser) { //Esto debido a que se uso livewire y response normal no toma el html correctamente
        $browser->loginAs($this->admin)
            ->visit('/almacenes')
            ->assertSee("Regresar");
        });
    }
    public function test_almacenes_regresar_button_redirects_successfully() 
    {
        $this->browse(function (Browser $browser) {
            $this->verifyLinkRedirection($browser, $this->admin, "/almacenes", "Regresar", "/inventarios");
        });
    }  

    public function test_almacenes_shows_all_data_successfully() 
    {
        $this->browse(function (Browser $browser) {
        $almacenes = Almacen::where('area_id', "DX00")->get();
        $browser->loginAs($this->admin)
            ->visit('/almacenes');
        foreach ($almacenes as $almacen) {
            $browser->assertSee($almacen->almacen_nombre)
                    ->assertSee($almacen->jefe_eid);
            
            if ($almacen->habilitado === 1) {
                $browser->assertChecked('input[value="check' . $almacen->id . '"]');
            } else {
                $browser->assertNotChecked('input[value="check' . $almacen->id . '"]');
            }
                    
        }
        });
    }

   public function test_almacenes_estado_checkbox_works() 
    {
        $this->browse(function (Browser $browser) {
        $almacenes = Almacen::where('area_id', "DX00")->get();
        $browser->loginAs($this->admin)
            ->visit('/almacenes');
        foreach ($almacenes as $almacen) {
            //dump( $almacen->habilitado);
            if ($almacen->habilitado === 1) {
                $browser->click('#slide'.$almacen->id)->pause(1000);
                $almacenNuevo = Almacen::where('id',  $almacen->id)->first();
                $this->assertEquals(0, $almacenNuevo->habilitado);
                $browser->click('#slide'.$almacen->id)->pause(1000);
                $almacenNuevo = Almacen::where('id',  $almacen->id)->first();
                $this->assertEquals(1, $almacenNuevo->habilitado);
            } else {
                $browser->click('#slide'.$almacen->id)->pause(1000);
                $almacenNuevo = Almacen::where('id',  $almacen->id)->first();
                $this->assertEquals(1, $almacenNuevo->habilitado);
                $browser->click('#slide'.$almacen->id)->pause(1000);
                $almacenNuevo = Almacen::where('id',  $almacen->id)->first();
                $this->assertEquals(0, $almacenNuevo->habilitado);
            }
                    
        }
        });
    }  

    public function test_almacenes_cambiar_jefe_almacen_works() 
    {
        
        $this->browse(function (Browser $browser) {
            $almacenes = Almacen::where('area_id', "DX00")->get();
            $browser->loginAs($this->admin)
            ->visit('/almacenes')
            ->press($almacenes->first()->jefe_eid)
            ->type("#buscaeid", "9AJ00")
            ->press("Buscar")
            ->clear("#buscaeid")
            ->pause(1000)
            ->assertDontSee("no encontrado")->assertDontSee("ya es jefe de este Almacen")
            ->press("#botonGuardar")->pause(1000);
            $almacenes = Almacen::where('jefe_eid', "9AJ00")->get();
            $browser->assertSee($almacenes->first()->jefe_eid);
            $browser
            ->press($almacenes->first()->jefe_eid)
            ->type("#buscaeid", "9AJ0R")
            ->press("Buscar")
            ->clear("#buscaeid")
            ->pause(100)
            ->assertDontSee("no encontrado")->assertDontSee("ya es jefe de este Almacen")
            ->press("#botonGuardar");
        });
    }  

    public function test_almacenes_jefe_repetido_shows_error() 
    {
        
        $this->browse(function (Browser $browser) {
            $almacenes = Almacen::where('area_id', "DX00")->get();
            $browser->loginAs($this->admin)
            ->visit('/almacenes')
            ->press($almacenes->first()->jefe_eid)
            ->type("#buscaeid", $almacenes->first()->jefe_eid)
            ->press("Buscar")
            ->clear("#buscaeid")
            ->pause(1000)
            ->assertSee("ya es jefe de este Almacen");
        });
    } 
    public function test_almacenes_jefe_not_found_shows_error() 
    {
        
        $this->browse(function (Browser $browser) {
            $almacenes = Almacen::where('area_id', "DX00")->get();
            $browser->loginAs($this->admin)
            ->visit('/almacenes')
            ->press($almacenes->first()->jefe_eid)
            ->type("#buscaeid", "32d")
            ->press("Buscar")
            ->clear("#buscaeid")
            ->pause(1000)
            ->assertSee("no encontrado");
        });
    } 

    public function test_almacenes_jefe_otra_area_shows_error() 
    {
        
        $this->browse(function (Browser $browser) {
            $almacenes = Almacen::where('area_id', "DX00")->get();
            $browser->loginAs($this->admin)
            ->visit('/almacenes')
            ->press($almacenes->first()->jefe_eid)
            ->type("#buscaeid", "ADMIN")
            ->press("Buscar")
            ->clear("#buscaeid")
            ->pause(1000)
            ->assertSee("no Pertenece al Area");
        });
    }
}
