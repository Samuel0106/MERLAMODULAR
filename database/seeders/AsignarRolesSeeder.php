<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\DatosUser;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AsignarRolesSeeder extends Seeder {
    public function run() {
        // Verificar si los roles existen, si no, crearlos
        $roles = ['admin', 'JefeDivision', 'JefeArea', 'JefeSubarea', 'JefeInventario', 'personal'];
        foreach ($roles as $rol) {
            Role::firstOrCreate(['name' => $rol]);
        }

        // Obtener los datos de usuarios con su puesto desde la tabla datosuser
        $datosUsuarios = DB::table('datosusers')->get();

        foreach ($datosUsuarios as $datos) {
            // Buscar el usuario en la tabla users basado en la relación eid = eid
            $usuario = User::where('eid', $datos->eid)->first();

            if ($usuario) { // Si el usuario existe en la tabla users
                switch ($datos->puesto) {
                    case 1:
                        $usuario->assignRole('admin');
                        break;
                    case 2:
                        $usuario->assignRole('JefeDivision');
                        break;
                    case 3:
                        // Alternar entre JefeArea, JefeSubarea y JefeInventario
                        $rolesAlternados = ['JefeArea', 'JefeSubarea', 'JefeInventario'];
                        $rolAsignado = $rolesAlternados[$usuario->id % 3]; // Alterna entre los 3
                        $usuario->assignRole($rolAsignado);
                        break;
                    case 4:
                        $usuario->assignRole('personal');
                        break;
                }
            }
        }
    }
}