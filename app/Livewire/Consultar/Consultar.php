<?php

namespace App\Livewire\Consultar;

use App\Livewire\Reporte\VerReporte;
use App\Mail\OkConsulta;
use App\Models\HistorialReporte;
use App\Models\Impacto;
use App\Models\Panal;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class Consultar extends Component
{

    public $search, $item, $impacto, $impactoEmail, $responsable, $responsableEmail;
    protected $listeners = ['render'];

    public function render()
    {

        $reporte = Reporte::where('consecutivo', $this->search)->get();

        return view('livewire.consultar.consultar', compact(
            'reporte'
        ));
    }

    public function selecItem($item, $action)
    {
        $this->item = $item;

        if ($action == 'ver') {
            $this->dispatch('getModelId', $this->item)->to(VerReporte::class);
        } else {
            $this->dispatch('getModelId', $this->item)->to(RechazarConsulta::class);
        }
    }


    public function aceptar($item)
    {
        $this->item = $item;

        $reporte = Reporte::find($this->item);
        $this->responsable = $reporte->responsable_id;
        $this->impacto = json_decode($reporte->impactos);

        if ($reporte->estado == 5) {
            $reporte->estado =  4;
            $reporte->update();

            $users = User::where('id', $this->responsable)->get();
            foreach ($users as $item) {
                $this->responsableEmail = $item->email;
            }

            Mail::to($this->responsableEmail)->queue(new OkConsulta($reporte));

            foreach ($this->impacto as $i) {
                $id = $i;
                $impactoLocal = Impacto::where('id', $id)->get();
                foreach ($impactoLocal as $item) {
                    $idUser = $item->user_id;
                    $users = User::where('id', $idUser)->get();
                    foreach ($users as $item) {
                        $this->impactoEmail = $item->email;
                    }
                    Mail::to($this->impactoEmail)->queue(new OkConsulta($reporte));
                }
            }

            $reportador = User::where('name', 'Generico')->get();
            foreach ($reportador as $key) {
                $idRepor = $key->id;
            }
            // Registrar en el historial
            HistorialReporte::create([
                'reporte_id' => $reporte->id,
                'user_id' => $idRepor,
                'accion' => 'Rechazado',
                'detalle' => 'Reporte Rechazado, el reportador acepto el rechazo del reporte',
            ]);


            $this->dispatch('okConsulta');
            $this->dispatch('render', Consultar::class);
        } else {
            $reporte->estado =  3;
            $reporte->update();

            $users = User::where('id', $this->responsable)->get();
            foreach ($users as $item) {
                $this->responsableEmail = $item->email;
            }

            Mail::to($this->responsableEmail)->queue(new OkConsulta($reporte));

            foreach ($this->impacto as $i) {
                $id = $i;
                $impactoLocal = Impacto::where('id', $id)->get();
                foreach ($impactoLocal as $item) {
                    $idUser = $item->user_id;
                    $users = User::where('id', $idUser)->get();
                    foreach ($users as $item) {
                        $this->impactoEmail = $item->email;
                    }
                    Mail::to($this->impactoEmail)->queue(new OkConsulta($reporte));
                }
            }

            $reportador = User::where('name', 'Generico')->get();
            foreach ($reportador as $key) {
                $idRepor = $key->id;
            }
            // Registrar en el historial
            HistorialReporte::create([
                'reporte_id' => $reporte->id,
                'user_id' => $idRepor,
                'accion' => 'Finalizado',
                'detalle' => 'Reporte Finalizado, el reportador acepto la solucion del reporte',
            ]);


            $this->dispatch('okConsulta');
            $this->dispatch('render', Consultar::class);
        }
    }
}
