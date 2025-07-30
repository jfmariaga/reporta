<?php

namespace App\Livewire\Comentario;

use App\Mail\Comentario as MailComentario;
use App\Models\Comentario;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class NewComentario extends Component
{
    public $reporte_id, $responsable, $userEmail, $consecutivo,$reporEmail;
    public $mensaje;
    public $estado = '';
    public $comentarios = [];

    protected $rules = [
        'mensaje' => 'required|string|max:255',
    ];

    #[On('getModelId')]
    public function getModelId($id)
    {
        $this->reporte_id = $id;
        $this->comentarios = Comentario::where('reporte_id', $this->reporte_id)->with('user')
            ->latest()
            ->get();

        $reporte = Reporte::find($this->reporte_id);
        $this->estado = $reporte->estado;
        $this->responsable = $reporte->responsable_id;
        $this->consecutivo = $reporte->consecutivo;
        $this->reporEmail = $reporte->email;
    }

    public function submit()
    {
        $this->validate();

        Comentario::create([
            'reporte_id' => $this->reporte_id,
            'comentario' => $this->mensaje,
            'user_id' => Auth::check() ? Auth::id() : null,
        ]);

        $this->comentarios = Comentario::where('reporte_id', $this->reporte_id)->with('user')
            ->latest()
            ->get();

        $users = User::where('id', $this->responsable)->get();
        foreach ($users as $item) {
            $this->userEmail = $item->email;
        }
        $datos = [
            'mensaje' => $this->mensaje,
            'consecutivo' => $this->consecutivo
        ];

        if (Auth::check()) {
            //correo para el jefe del area
            Mail::to($this->reporEmail)->queue(new MailComentario($datos));

        } else {
            //correo para la persona que reporta
            Mail::to($this->userEmail)->queue(new MailComentario($datos));
        }

        $this->mensaje = '';
    }

    public function render()
    {
        return view('livewire.comentario.new-comentario');
    }
}
