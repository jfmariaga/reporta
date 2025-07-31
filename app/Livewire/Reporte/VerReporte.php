<?php

namespace App\Livewire\Reporte;

use App\Livewire\Comentario\NewComentario;
use App\Mail\CerrarReporte;
use App\Mail\EditReporte;
use App\Mail\RecategorizarReporte;
use App\Models\Area;
use App\Models\Cargo;
use App\Models\Gestion;
use App\Models\HistorialReporte;
use App\Models\Impacto;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class VerReporte extends Component
{
    use WithFileUploads;

    public $modelId, $class, $check, $area, $cargo, $zona, $zonas = null, $nombre, $impacto, $descripcion, $orden, $prioridad, $img, $img2, $img3, $identificar, $responsable, $consecutivo, $userName, $userEmail, $estado, $respuesta, $loginRepor, $comentario;
    public $item, $seguimiento, $reporEmail, $historial;
    protected $rules = [
        'area' => 'required',
        'cargo' => 'required',
        'zona' => 'required',
        'nombre' => 'required',
        'descripcion' => 'required',
        'prioridad' => 'required',
        'img' => 'required',
    ];
    protected $listeners = ['getModelId'];
    #[On('getModelId')]
    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = Reporte::find($this->modelId);
        $this->impacto = json_decode($model->impactos);
        $this->area = $model->area;
        $this->cargo = $model->cargo_id;
        $this->zona = $model->zona;
        $this->nombre = $model->ReportadoPor;
        $this->descripcion = $model->descripcion;
        $this->prioridad = $model->prioridad;
        $this->img = $model->adjunto;
        $this->orden = $model->orden;
        $this->estado = $model->estado;
        $this->consecutivo = $model->consecutivo;
        $this->respuesta = $model->resuesta;
        $this->img3 = $model->adjunto_after;
        $this->comentario = $model->comentario;
        $this->seguimiento = $model->seguimiento;
        $this->reporEmail = $model->email;

        if ($this->modelId) {
            $this->historial = HistorialReporte::where('reporte_id', $this->modelId)->orderBy('created_at', 'Asc')->get();
        }
    }

    #[On('render')]
    public function render()
    {
        if ($this->check) {
            $this->class = "";
        } else {
            $this->class = "d-none";
        }

        $areas = Area::all();
        $areasUnicas = $areas->unique('area');
        $cargos = Cargo::all();
        $impactos = Impacto::all();

        return view('livewire.reporte.ver-reporte', compact('areasUnicas', 'cargos', 'areas', 'impactos'));
    }



    public function recategorizarReporte()
    {
        $user = Auth::user();

        if ($this->estado != 1) {
            session()->flash('error', 'El reporte solo puede ser recategorizado cuando está en estado Pendiente.');
            return;
        }

        if (!$user->hasRole('JefeArea')) {
            session()->flash('error', 'Solo el Jefe de Área puede recategorizar el reporte.');
            return;
        }

        $this->validate([
            'area' => 'required',
            'impacto' => 'required|array',
        ]);

        $reporte = Reporte::find($this->modelId);
        $reporte->area = $this->area;
        $reporte->impactos = json_encode($this->impacto);
        $reporte->update();

        $resArea = Gestion::where('area', $reporte->area)->get();

        foreach ($resArea as $item) {
            $this->responsable = $item->user_id;
        }


        $users = User::where('id', $this->responsable)->get();
        foreach ($users as $item) {
            $this->userEmail = $item->email;
        }
        //correo para el jefe del area
        Mail::to($this->userEmail)->queue(new RecategorizarReporte($reporte));

        // Registrar en el historial
        HistorialReporte::create([
            'reporte_id' => $reporte->id,
            'user_id' => Auth::id(),
            'accion' => 'Recategorizado',
            'detalle' => 'Reporte recategorizado a ' . $this->area,
        ]);


        //correo para notificar al reportador el cambio de estado del reporte
        // Mail::to($this->reporEmail)->queue(new EditReporte($reporte));

        $this->reset();
        $this->dispatch('updateReporte');
        $this->dispatch('cargarReportes')->to(Index::class);
    }

    public function update()
    {
        $this->validate();
        if ($this->img2 != null) {
            $url = $this->img2->store('public/adjunto');
        } elseif ($this->img3 != null) {
            $url = $this->img3;
        } else {
            $url = null;
        }

        $reporte = Reporte::find($this->modelId);
        $reporte->estado = 2;
        $reporte->orden = $this->orden;
        $reporte->resuesta = $this->respuesta;
        $reporte->adjunto_after = $url;
        $reporte->update();

        // Registrar en el historial
        HistorialReporte::create([
            'reporte_id' => $reporte->id,
            'user_id' => Auth::id(),
            'accion' => 'En proceso',
            'detalle' => 'El reporte cambio de estado pendiente a en proceso',
        ]);

        //correo para notificar al reportador el cambio de estado del reporte
        Mail::to($this->reporEmail)->queue(new EditReporte($reporte));

        $this->reset();
        $this->dispatch('updateReporte');
        $this->dispatch('cargarReportes')->to(Index::class);
    }

    public function cerrar()
    {
        if ($this->img2 != null) {
            $url = $this->img2->store('public/adjunto');
        } elseif ($this->img3 != null) {
            $url = $this->img3;
        } else {
            $url = null;
        }

        $this->validate([
            'respuesta' => 'required',
            'seguimiento' => 'required',
        ]);

        $cerrar = Reporte::find($this->modelId);
        $cerrar->estado = 6;
        $cerrar->orden = $this->orden;
        $cerrar->seguimiento = $this->seguimiento;
        $cerrar->resuesta = $this->respuesta;
        $cerrar->adjunto_after = $url;
        $cerrar->update();

        //correo para notificar al reportador el cambio de estado del reporte
        Mail::to($this->reporEmail)->queue(new CerrarReporte($cerrar));

        // Registrar en el historial
        HistorialReporte::create([
            'reporte_id' => $cerrar->id,
            'user_id' => Auth::id(),
            'accion' => 'En seguimiento',
            'detalle' => 'El reporte cambio de estado a en seguimiento',
        ]);
        $this->reset();
        $this->dispatch('reporteCerrado');
        $this->dispatch('cargarReportes')->to(Index::class);
    }

    public function finalizar()
    {
        $this->validate();

        if ($this->img2 != null) {
            $url = $this->img2->store('public/adjunto');
        } elseif ($this->img3 != null) {
            $url = $this->img3;
        } else {
            $url = null;
        }
        $repor = Reporte::find($this->modelId);
        $repor->estado = 3;
        $repor->orden = $this->orden;
        $repor->resuesta = $this->respuesta;
        $repor->adjunto_after = $url;
        $repor->update();

        // Registrar en el historial
        HistorialReporte::create([
            'reporte_id' => $repor->id,
            'user_id' => Auth::id(),
            'accion' => 'Finalizado',
            'detalle' => 'El reporte cambio de estado a Finalizado',
        ]);
        $this->reset();
        $this->dispatch('reporteFinalizado');
        $this->dispatch('cargarReportes')->to(Index::class);
    }

    public function mount()
    {
        $this->identificar = rand();
    }

    public function resetear()
    {
        $this->reset();
        $this->identificar = rand();
    }

    public function pasarId($item)
    {
        $this->item = $item;
        $this->dispatch('getModelId', $this->item)->to(NewComentario::class);
    }
}
