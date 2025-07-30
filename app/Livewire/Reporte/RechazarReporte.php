<?php

namespace App\Livewire\Reporte;

use App\Mail\Rechazo;
use App\Mail\RechazoImpacto;
use App\Models\HistorialReporte;
use App\Models\Impacto;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class RechazarReporte extends Component
{
    public $modelId,$respuesta, $userEmail,$impacto,$impactoEmail;

    protected $rules = [
        'respuesta' => 'required',
    ];

    public function render()
    {
        return view('livewire.reporte.rechazar-reporte');
    }

    #[On('getModelId')]
    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = Reporte::find($this->modelId);
        $this->userEmail = $model->email;
        $this->impacto = json_decode($model->impactos);
    }

    public function update()
    {

        $this->validate();

        $reporte = Reporte::find($this->modelId);
        $reporte->resuesta =  $this->respuesta;
        $reporte->estado =  5;
        $reporte->update();

        Mail::to($this->userEmail)->queue(new Rechazo($reporte));

        foreach ($this->impacto as $i) {
            $id = $i;
            $impactoLocal = Impacto::where('id', $id)->get();
            foreach ($impactoLocal as $item) {
                $idUser = $item->user_id;
                $users = User::where('id', $idUser)->get();
                foreach ($users as $item) {
                    $this->impactoEmail = $item->email;
                }
                Mail::to($this->impactoEmail)->queue(new RechazoImpacto($reporte));
            }
        }

         // Registrar en el historial
         HistorialReporte::create([
            'reporte_id' => $reporte->id,
            'user_id' => Auth::id(),
            'accion' => 'Por aceptacion',
            'detalle' => 'Reporte enviado para aceptación por rechazo',
        ]);

        $this->reset();
        $this->dispatch('rechazoReporte');
        $this->dispatch('cargarReportes')->to(Index::class );
    }

    public function resetear()
    {
        $this->reset();
    }
}
