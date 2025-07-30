<?php

namespace App\Livewire\Card;

use App\Models\Gestion;
use App\Models\Impacto;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public $chartData;

    public function mount()
    {
        $this->chartData = $this->getChartData();
        logger()->info('ChartData', ['data' => $this->chartData]);  // Agrega esta línea para depurar
    }


    public function getChartData()
    {
        $user = Auth::user();
        $reportesQuery = Reporte::query();

        if ($user->hasRole('JefeArea')) {
            $areaId = Gestion::where('user_id', $user->id)->pluck('area');
            $reportesQuery->whereIn('area', $areaId);
        } elseif ($user->hasRole('JefeImpacto')) {
            $impactoIds = Impacto::where('user_id', $user->id)->pluck('id')->toArray();
            $reportesQuery->where(function ($query) use ($impactoIds) {
                foreach ($impactoIds as $impactoId) {
                    $query->orWhereJsonContains('impactos', (string)$impactoId);
                }
            });
        }

        // Consulta los datos de la base de datos y cuenta los reportes por estado
        $pendiente = (clone $reportesQuery)->where('estado', 1)->count();
        $proceso = (clone $reportesQuery)->where('estado', 2)->count();
        $finalizado = (clone $reportesQuery)->where('estado', 3)->count();
        $rechazo = (clone $reportesQuery)->where('estado', 4)->count();
        $aceptacion = (clone $reportesQuery)->where('estado', 5)->count();
        $seguimiento = (clone $reportesQuery)->where('estado', 6)->count();
        $abierto = (clone $reportesQuery)->where('estado', 7)->count();

        // Define las etiquetas y los datos
        $labels = ['Pendiente', 'En Proceso', 'Finalizado', 'Rechazado', 'Por Aceptación','Seguimiento', 'Re-Abierto'];
        $data = [$pendiente, $proceso, $finalizado, $rechazo, $aceptacion, $seguimiento, $abierto ];
        $colors = ['#36A2EB', '#FFCE56', '#33FF57', '#FF6384', '#6C757D', '#343A40', '#007BFF'];

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Reportes por Estado',
                    'backgroundColor' => $colors,
                    'data' => $data,
                ],
            ],
        ];
    }




    public function updateChartData()
    {
        $this->chartData = $this->getChartData();
        $this->dispatch('chartDataUpdated', ['chartData' => $this->chartData]);
    }

    public function render()
    {
        return view('livewire.card.index');
    }
}
