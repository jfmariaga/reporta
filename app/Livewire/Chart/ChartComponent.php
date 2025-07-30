<?php

namespace App\Livewire\Chart;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartComponent extends Component
{
    public $chartData;

    public function mount()
    {
        $this->chartData = $this->getChartData();
    }

    public function getChartData()
    {
        // Consulta los datos de la base de datos, agrupando por área y contando los reportes
        $reportes = DB::table('reportes')
            ->select('area', DB::raw('count(*) as total'))
            ->groupBy('area')
            ->get();

        // Procesa los datos para el gráfico
        $labels = $reportes->pluck('area')->toArray();
        $data = $reportes->pluck('total')->toArray();

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Reportes por área',
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1,
                    'data' => $data,
                ],
            ],
        ];
    }

    public function render()
    {
        $this->mount();
        return view('livewire.chart.chart-component');
    }
}
