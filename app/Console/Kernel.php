<?php

namespace App\Console;

use Carbon\Carbon;use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;use Illuminate\Support\Facades\DB;use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $fechaActual = Carbon::today();
            $fecha =  $fechaActual->year . '-' . $fechaActual->month . '-' . $fechaActual->day;

            $vacantes = DB::table("vacantes");
            $vacantes = $vacantes->get();

            $vacantesId = [];

            foreach ($vacantes as $vacante){
                if($vacante->fecha_fin == $fecha){
                    $vacantesId[] = $vacante->id;
                }
            }

            $usuarios_vacantes = DB::table("usuarios_vacantes");

            foreach ($vacantesId as $vacante){
                $cvs = [];
                foreach ($usuarios_vacantes->where('vacante_id', '=', $vacantesId[0])->get() as $usuario_vacante){
                    $cvs[] = $usuario_vacante->cv;
                }

                //@Todo enviar mail a todos los responsables
                Mail::send('cargarResultado', [
                    'vacante' => $vacante,
                    'cvs' => $cvs,
                    ],
                    function ($message){
                        $message->from('info@entornos-frro.tk');
                        $message->to('agustincordoba28@gmail.com', 'Test')
                        ->subject('Habilitación a cargar resultado');
                    }
                );
            }
        })->dailyAt('18:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
