<?php

namespace App\Console\Commands;

use App\Models\Reporte;
use Illuminate\Console\Command;
use Carbon\Carbon;

class RevisarReportes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'revisar-reportes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa los reportes y actualiza su estado si la fecha de seguimiento ha pasado.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $reportes = Reporte::where('estado', 6)->get()->toArray();
        $datetime1 = date_create(date('Y-m-d'));
        foreach ($reportes as $reporte) {
            $datetime2 = date_create($reporte->seguimiento);
            if ($datetime2 < $datetime1) {
                $reporte->estado = 3;
                $reporte->save();
            }
        }
    }
}
