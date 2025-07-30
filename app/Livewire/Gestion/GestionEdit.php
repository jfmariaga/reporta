<?php

namespace App\Livewire\Gestion;

use App\Models\Area;
use App\Models\Gestion;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class GestionEdit extends Component
{
    public $responsable, $area,$modelId;
    protected $listeners = ['render'];

    protected $rules = [
        'area' => 'required',
    ];

    public function render()
    {
        $areas = Area::all();
        $areasUnicas = $areas->unique('area');
        $usuarios = User::all();
        return view('livewire.gestion.gestion-edit',compact('areasUnicas','usuarios'));
    }

    #[On('getModelId')]
    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = Gestion::find($this->modelId);
        $this->area = $model->area;
        $this->responsable = $model->user_id;
    }

    public function update()
    {

        $this->validate();

        $impacto = Gestion::find($this->modelId);
        $impacto->area =  $this->area;
        $impacto->user_id =  $this->responsable;
        $impacto->update();

        $this->reset();
        $this->dispatch('edit_gestion');
        $this->dispatch('render', Index::class);
    }

    public function resetear()
    {
        $this->reset();
    }
}
