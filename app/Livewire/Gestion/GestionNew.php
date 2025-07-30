<?php

namespace App\Livewire\Gestion;

use App\Models\Area;
use App\Models\Gestion;
use App\Models\User;
use Livewire\Component;

class GestionNew extends Component
{
    public $responsable, $area;
    protected $listeners = ['render'];

    protected $rules = [
        'area' => 'required',
        'responsable' => 'required',
    ];
    public function render()
    {
        $areas = Area::all();
        $areasUnicas = $areas->unique('area');
        $usuarios = User::all();

        return view('livewire.gestion.gestion-new',compact('areasUnicas','usuarios'));
    }

    public function guardar()
    {
        $this->validate();

        $datos = [
            'area' => $this->area,
            'user_id' => $this->responsable
        ];

        Gestion::create($datos);
        $this->reset();
        $this->dispatch('ok_gestion');
        $this->dispatch('render');
    }

    public function resetear()
    {
        $this->reset();
    }
}
