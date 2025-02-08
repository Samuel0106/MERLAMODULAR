<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Exports\NotificacionesExport;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class NotificacionesController extends Controller
{
    public function exportNotificationsExcel(){
        $notificaciones = Notificacion::whereNull('exportado')->get();

        if($notificaciones->count() == 0)
            return "no hay notificaciones";

        $fechaActual = Carbon::now();
        $exportData = [];
        foreach ($notificaciones as $notificacion) {
            $exportData[] = [
                'destinatario' => $notificacion->destinatario,
                'asunto' => $notificacion->asunto,
                'cuerpo' => $notificacion->cuerpo
            ];

            $notificacion->exportado = $fechaActual;
            $notificacion->save();
        }
        $nombre = "correo.csv"; 
        $headers = [
            'Content-Encoding' => 'UTF-8',
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename='.$nombre,
        ];

        //return Excel::download(new NotificacionesExport($exportData), 'notificaciones.xlsx');
        return (new Response(Excel::raw(new NotificacionesExport($exportData), \Maatwebsite\Excel\Excel::CSV), 200, $headers))
            ->header('Content-Type', 'text/csv');
    }
}
