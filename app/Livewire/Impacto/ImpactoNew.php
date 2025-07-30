<?php

namespace App\Livewire\Impacto;

use App\Models\Impacto;
use App\Models\User;
use Livewire\Component;

class ImpactoNew extends Component
{
    public $responsable, $impacto;
    protected $listeners = ['render'];

    protected $rules = [
        'responsable' => 'required',
        'impacto' => 'required',
    ];

    public function render()
    {
        $usuarios = User::all();
        return view('livewire.impacto.impacto-new',compact('usuarios'));
    }

    public function guardar(){
        $this->validate();

        $datos=[
            'impacto' => $this->impacto,
            'user_id'=>$this->responsable
        ];

        Impacto::create($datos);
        $this->reset();
        $this->dispatch('ok_impacto');
        $this->dispatch('render');
    }

    public function resetear(){
        $this->reset();
    }
}
