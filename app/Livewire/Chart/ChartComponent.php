<?php

namespace App\Livewire\Chart;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChartComponent extends Component
{
    public $labelsAreas = [];
    public $seriesAreas = [];
    public $labelsImpactos = [];
    public $seriesImpactos = [];
    public $labelsEstados = [];
    public $seriesEstados = [];
    public $seriesZonasImpacto = [];

    public function mount()
    {
        // ====== Datos por Área ======
        $areas = DB::table('reportes')
            ->select('area', DB::raw('count(*) as total'))
            ->groupBy('area')
            ->get();

        $this->labelsAreas = $areas->pluck('area')->toArray();
        $this->seriesAreas = $areas->pluck('total')->toArray();

        // ====== Datos por Impactos ======
        $impactos = DB::table('reportes')
            ->select('impactos')
            ->get()
            ->flatMap(function ($reporte) {
                return json_decode($reporte->impactos, true);
            })
            ->countBy()
            ->mapWithKeys(function ($count, $impactoId) {
                $nombreImpacto = DB::table('impactos')->where('id', $impactoId)->value('impacto');
                return [$nombreImpacto => $count];
            });

        $this->labelsImpactos = $impactos->keys()->toArray();
        $this->seriesImpactos = $impactos->values()->toArray();

        // ====== Datos por Estado ======
        $estadoMap = [
            1 => 'PENDIENTE',
            2 => 'EN PROCESO',
            3 => 'FINALIZADO',
            4 => 'RECHAZADO',
            5 => 'POR ACEPTACION',
            6 => 'SEGUIMIENTO',
            7 => 'RE-ABIERTO'
        ];

        $estados = DB::table('reportes')
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get()
            ->map(function ($item) use ($estadoMap) {
                return [
                    'estado_text' => $estadoMap[$item->estado] ?? 'DESCONOCIDO',
                    'total' => $item->total
                ];
            });

        $this->labelsEstados = $estados->pluck('estado_text')->toArray();
        $this->seriesEstados = $estados->pluck('total')->toArray();

        // ====== Zonas con mayor impacto (Treemap) ======
        $zonas = DB::table('reportes')
            ->select('zona', DB::raw('count(*) as total'))
            ->groupBy('zona')
            ->orderByDesc('total')
            ->get()
            ->map(function ($item) {
                return ['x' => $item->zona, 'y' => $item->total];
            })
            ->toArray();

        $this->seriesZonasImpacto = [['data' => $zonas]];
    }

    public function render()
    {
        return view('livewire.chart.chart-component');
    }
}
