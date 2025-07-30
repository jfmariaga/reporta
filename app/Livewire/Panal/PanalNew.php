<?php

namespace App\Livewire\Panal;

use App\Models\Panal;
use App\Models\User;
use Livewire\Component;

class PanalNew extends Component
{
    public $responsable, $area;
    protected $listeners = ['render'];

    protected $rules = [
        'area' => 'required',
        'responsable' => 'required',
    ];

    public function render()
    {
        $usuarios = User::all();

        return view('livewire.panal.panal-new',compact('usuarios'));
    }

    public function guardar()
    {
        $this->validate();

        $datos = [
            'area' => $this->area,
            'user_id' => $this->responsable
        ];

        Panal::create($datos);
        $this->reset();
        $this->dispatch('ok_panal');
        $this->dispatch('render');
    }

    public function resetear()
    {
        $this->reset();
    }
}
