<?php

namespace App\Livewire\Panal;

use App\Models\Panal;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class PanalEdit extends Component
{
    public $responsable, $area, $modelId;

    protected $rules = [
        'area' => 'required',
    ];

    public function render()
    {
        $usuarios = User::all();

        return view('livewire.panal.panal-edit',compact('usuarios'));
    }


    #[On('getModelId')]
    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = Panal::find($this->modelId);
        $this->area = $model->area;
    }

    public function update()
    {

        $this->validate();

        $impacto = Panal::find($this->modelId);
        $impacto->area =  $this->area;
        $impacto->update();

        $this->reset();
        $this->dispatch('edit_Panal');
        $this->dispatch('render', Index::class);
    }

    public function resetear()
    {
        $this->reset();
    }
}
