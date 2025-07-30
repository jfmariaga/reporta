<?php

namespace App\Livewire\Reportador;

use App\Models\Reportador;
use Livewire\Attributes\On;
use Livewire\Component;

class ReportadorEdit extends Component
{
    public $nombre, $cc, $email,$modelId;

    protected $rules = [
        'nombre' => 'required',
        'cc' => 'required',
        'email' => 'required'
    ];

    public function render()
    {
        return view('livewire.reportador.reportador-edit');
    }

    #[On('getModelId')]
    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = Reportador::find($this->modelId);
        $this->nombre = $model->nombre;
        $this->cc = $model->cc;
        $this->email = $model->email;
    }

    public function update()
    {

        $this->validate();

        $impacto = Reportador::find($this->modelId);
        $impacto->nombre =  $this->nombre;
        $impacto->email = $this->email;
        $impacto->cc = $this->cc;
        $impacto->update();

        $this->reset();
        $this->dispatch('edit_reportador');
        $this->dispatch('render', Index::class);
    }

    public function resetear()
    {
        $this->reset();
    }
}
