<?php

namespace App\Livewire\Impacto;

use App\Models\Impacto;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class ImpactoEdit extends Component
{
    public $responsable, $impacto, $modelId;


    protected $rules = [
        'responsable' => 'required',
        'impacto' => 'required',
    ];
    public function render()
    {
        $usuarios = User::all();
        return view('livewire.impacto.impacto-edit', compact('usuarios'));
    }

    #[On('getModelId')]
    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = Impacto::find($this->modelId);
        $this->impacto = $model->impacto;
        $this->responsable = $model->user_id;
    }

    public function update()
    {

        $this->validate();

        $impacto = Impacto::find($this->modelId);
        $impacto->impacto =  $this->impacto;
        $impacto->user_id = $this->responsable;
        $impacto->update();

        $this->reset();
        $this->dispatch('editImpacto');
        $this->dispatch('render', Index::class);
    }

    public function resetear()
    {
        $this->reset();
    }
}
