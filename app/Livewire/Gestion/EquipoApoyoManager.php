<?php

namespace App\Livewire\Gestion;

use Livewire\Component;
use App\Models\User;
use App\Models\EquipoApoyo;

class EquipoApoyoManager extends Component
{
    public $responsable_id;
    public $apoyo_id;
    public $equipos = [];

    protected $listeners = ['cargarResponsable'];

    protected $rules = [
        'apoyo_id' => 'required'
    ];

    public function render()
    {
        $usuarios = User::all();

        return view('livewire.gestion.equipo-apoyo-manager', compact('usuarios'));
    }

    // 🔹 Se ejecuta cuando haces clic en una fila
    public function cargarResponsable($responsable_id)
    {
        $this->responsable_id = $responsable_id;

        $this->cargarEquipos();
    }

    // 🔹 Cargar solo el equipo de ese responsable
    public function cargarEquipos()
    {
        $this->equipos = EquipoApoyo::where('responsable_id', $this->responsable_id)
            ->with('apoyo')
            ->get();
    }

    public function agregar()
    {
        $this->validate();

        EquipoApoyo::create([
            'responsable_id' => $this->responsable_id,
            'apoyo_id' => $this->apoyo_id,
        ]);

        $this->reset('apoyo_id');

        $this->cargarEquipos();
    }

    public function eliminar($id)
    {
        EquipoApoyo::find($id)?->delete();

        $this->cargarEquipos();
    }

    public function limpiar()
    {
        $this->responsable_id = '';
        $this->equipos = [];
    }
}
