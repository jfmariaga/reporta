<?php

namespace App\Livewire\Reporte;

use App\Models\Gestion;
use App\Models\Impacto;
use App\Models\Reporte;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public $item;

    public function render()
    {
        return view('livewire.reporte.index');
    }

    #[On('aceptarReporte')]
    public function aceptarReporte()
    {
        $this->dispatch('confirmar');
    }

    // #[On('cargarReportes')]
    // public function cargarReportes()
    // {
    //     $user = Auth::user();
    //     $reportesQuery = Reporte::with('cargo');

    //     if ($user->hasRole('JefeArea')) {
    //         $areaId = Gestion::where('user_id', $user->id)->pluck('area');
    //         $reportesQuery->whereIn('area', $areaId);
    //     } elseif ($user->hasRole('JefeImpacto')) {
    //         $impactoIds = Impacto::where('user_id', $user->id)->pluck('id')->toArray();
    //         $reportesQuery->where(function ($query) use ($impactoIds) {
    //             foreach ($impactoIds as $impactoId) {
    //                 $query->orWhereJsonContains('impactos', (string)$impactoId);
    //             }
    //         });
    //     } elseif ($user->hasRole('Admin')) {
    //         // Los administradores pueden ver todos los reportes, no es necesario aplicar filtros adicionales
    //     }

    //     $reportes = $reportesQuery->get()->map(function ($reporte) use ($user) {
    //         $impactoNames = Impacto::whereIn('id', json_decode($reporte->impactos, true))->pluck('impacto')->toArray();
    //         $reporte->impacto_names = implode(', ', $impactoNames);
    //         $reporte->userRole = $user->getRoleNames()->first(); // Añadir el rol del usuario al reporte
    //         return $reporte;
    //     })->toArray();

    //     $this->dispatch('cargarReportesTabla', json_encode($reportes));
    // }

    #[On('cargarReportes')]
    public function cargarReportes()
    {
        $user = Auth::user();

        $reportesQuery = Reporte::with('cargo');

        // 🔴 ADMIN → ve todo
        if ($user->hasRole('Admin')) {
            // no se filtra nada
        }

        // 🔵 JEFE DE ÁREA → ve todo lo de su área
        elseif ($user->hasRole('JefeArea')) {

            $areas = Gestion::where('user_id', $user->id)
                ->pluck('area');

            $reportesQuery->whereIn('area', $areas);
        }

        // 🟢 RESPONSABLE (equipo o jefe asignado)
        else {

            $reportesQuery->where('responsable_id', $user->id);
        }

        // 🔵 JEFE IMPACTO (lo dejamos adicional)
        if ($user->hasRole('JefeImpacto')) {

            $impactoIds = Impacto::where('user_id', $user->id)
                ->pluck('id')
                ->toArray();

            $reportesQuery->where(function ($query) use ($impactoIds) {
                foreach ($impactoIds as $impactoId) {
                    $query->orWhereJsonContains('impactos', (string)$impactoId);
                }
            });
        }

        $reportes = $reportesQuery->get()->map(function ($reporte) use ($user) {

            $impactoNames = Impacto::whereIn(
                'id',
                json_decode($reporte->impactos, true)
            )->pluck('impacto')->toArray();

            $reporte->impacto_names = implode(', ', $impactoNames);
            $reporte->userRole = $user->getRoleNames()->first();

            return $reporte;
        })->toArray();

        $this->dispatch('cargarReportesTabla', json_encode($reportes));
    }



    #[On('info')]
    public function info($id)
    {
        $this->item = $id;
        $this->dispatch('getModelId', $this->item)->to(VerReporte::class);
    }

    #[On('Rechazo')]
    public function Rechazo($id)
    {
        $this->item = $id;
        $this->dispatch('getModelId', $this->item)->to(RechazarReporte::class);
    }
}
