<?php

namespace Tests\Helpers;

use App\Models\User;
use Tests\DuskTestCase;
use App\Models\Producto;
use App\Models\Categoria;
use Laravel\Dusk\Browser;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Console\DumpCommand;

trait TestHelpers
{
    private function createUser(string $role): User
    {
        if ($role === "admin") {
            return User::find(1); // Replace with your logic to find the admin user
        }

        return User::find(2); // Replace with your logic to find the regular user
    }

    private function verifyLinkRedirection(Browser $browser, User $session, string $visit, string $link, string $path)
    {
        $browser->loginAs($session)
        ->visit($visit)
        ->clickLink($link)
        ->assertPathIs($path);
    }
    public function verifyFilterProductsByCategoria(Browser $browser, User $session, $categoriaId)
    {
        $browser->loginAs($session)
            ->visit('/productos')
            ->select("#_categoria_filtro", $categoriaId)
            ->pause(1000)
            ->press('Filtrar')
            ->pause(1000);
        
        $productos = Producto::where('categoria_id', $categoriaId)->get();
        
        foreach ($productos as $producto) {
            $browser->assertSee($producto->nombre_prod)
                    ->assertSee($producto->unidad)
                    ->assertSee($producto->stock_min); 
        }
    } 
    public function verifyFilterProductsSoftDeletedByCategoria(Browser $browser, User $session, $categoriaId)
    {
        $browser->loginAs($session)
            ->visit('/productos')
            ->select("#_categoria_filtro", $categoriaId)
            ->check('#eliminados')
            ->press('Filtrar')
            ->pause(1000);
        
        $productos = Producto::where('categoria_id', $categoriaId)->get();
        foreach ($productos as $producto) {
            $browser->assertSee($producto->nombre_prod)
                    ->assertSee($producto->unidad)
                    ->assertSee($producto->stock_min); 
        }
        $browser->assertSee("Producto Eliminado");
    }

    public function verifyBorrarButtonInProductosSoftDeletesSuccessfully(Browser $browser, User $session, $categoriaId)
    {
        
        $browser->loginAs($session)
            ->visit('/productos')
            ->select("#_categoria_filtro", $categoriaId)
            ->press('Filtrar')
            ->pause(1000);
        
        $productos = Producto::where('categoria_id', $categoriaId)->get();
        $primerProducto = $productos->first();
        $idPrimerProducto = $primerProducto->id;
        $browser
        ->press('boton' . $idPrimerProducto)
        ->pause(1000);
        $productos = Producto::withTrashed()->where('categoria_id', $categoriaId)->get();
        $primerProducto = $productos->first();
        $response = $this->actingAs($this->admin)
        ->assertTrue($primerProducto->trashed() , 'Product is soft-deleted');
    }
    public function verifyButtonRedirectsSuccessfully(Browser $browser, User $session, string $visit, string $link, string $path, int $pause = 1000)
    {
        
        $browser->loginAs($session)
            ->visit($visit)
            ->press($link)
            ->pause($pause)
            ->assertPathIs($path);
    }

    public function verifyCategorias(Browser $browser, User $session, $categoriaId)
    {
        $browser->loginAs($session)
            ->visit('/categorias');
        
        $categorias = Categoria::where('id', $categoriaId)->get();
        
        foreach ($categorias as $categoria) {
            $browser->assertSee($categoria->nombre_cat);
        }
    } 

    public function truncateTableWithForeignKeys($model,string $seeder, bool $toSeed = false){
        
        Schema::disableForeignKeyConstraints();
        $model::truncate();
        if (!$toSeed) {
            Artisan::call('db:seed --class=' . $seeder);
        }
        Schema::enableForeignKeyConstraints();
    }
    public function verifyBorrarButtonDeletesSuccessfully(Browser $browser, User $session, $model, string $nombreTabla, string $elementoPorVerificar,  string $ruta,   string $nombreIdBoton,int $pause = 1000)
    {
        $instancia = $model::first();
        $browser->loginAs($session)
            ->visit($ruta)
            ->press($nombreIdBoton . $instancia->id)
            ->pause($pause);
        
        
        $this->assertDatabaseMissing($nombreTabla, [
            $elementoPorVerificar => $instancia->$elementoPorVerificar,
        ]);
    }

}