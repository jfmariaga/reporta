<?php

namespace App\Livewire\Consultar;

use App\Mail\RechazoConsulta;
use App\Models\Gestion;
use App\Models\HistorialReporte;
use App\Models\Impacto;
use App\Models\Panal;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class RechazarConsulta extends Component
{
    public $modelId, $comentario, $userEmail, $impacto, $impactoEmail, $areaTrabajo, $responsable, $responsableEmail;

    protected $rules = [
        'comentario' => 'required',
    ];
    public function render()
    {
        return view('livewire.consultar.rechazar-consulta');
    }

    #[On('getModelId')]
    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = Reporte::find($this->modelId);
        $this->userEmail = $model->email;
        $this->areaTrabajo = $model->area;
        $this->responsable = $model->responsable_id;
        $this->impacto = json_decode($model->impactos);
    }

    public function update()
    {

        $this->validate();

        $reporte = Reporte::find($this->modelId);
        $reporte->comentario =  $this->comentario;

        if ($reporte->estado == 5) {
            $reporte->estado =  7;
            $reporte->update();

            $users = User::where('id', $this->responsable)->get();
            foreach ($users as $item) {
                $this->responsableEmail = $item->email;
            }

            Mail::to($this->responsableEmail)->queue(new RechazoConsulta($reporte));

            foreach ($this->impacto as $i) {
                $id = $i;
                $impactoLocal = Impacto::where('id', $id)->get();
                foreach ($impactoLocal as $item) {
                    $idUser = $item->user_id;
                    $users = User::where('id', $idUser)->get();
                    foreach ($users as $item) {
                        $this->impactoEmail = $item->email;
                    }
                    Mail::to($this->impactoEmail)->queue(new RechazoConsulta($reporte));
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
                'accion' => 'Re-Abierto',
                'detalle' => 'Reporte Re-Abierto, el reportador no esta de acuerdo con el motivo de rechazo',
            ]);

            $this->reset();
            $this->dispatch('rechazoConsulta');
            $this->dispatch('render', Consultar::class);
        } else {
            $reporte->estado =  7;
            $reporte->update();

            $users = User::where('id', $this->responsable)->get();
            foreach ($users as $item) {
                $this->responsableEmail = $item->email;
            }

            Mail::to($this->responsableEmail)->queue(new RechazoConsulta($reporte));

            foreach ($this->impacto as $i) {
                $id = $i;
                $impactoLocal = Impacto::where('id', $id)->get();
                foreach ($impactoLocal as $item) {
                    $idUser = $item->user_id;
                    $users = User::where('id', $idUser)->get();
                    foreach ($users as $item) {
                        $this->impactoEmail = $item->email;
                    }
                    Mail::to($this->impactoEmail)->queue(new RechazoConsulta($reporte));
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
                'accion' => 'Re-Abierto',
                'detalle' => 'Reporte Re-Abierto, el reportador no esta de acuerdo con la solucion del reporte',
            ]);

            $this->reset();
            $this->dispatch('rechazoConsulta');
            $this->dispatch('render', Consultar::class);
        }
    }

    public function resetear()
    {
        $this->reset();
    }
}
