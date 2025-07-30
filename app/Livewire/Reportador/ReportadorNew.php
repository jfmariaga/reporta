<?php

namespace App\Livewire\Reportador;

use App\Models\Reportador;
use Livewire\Component;

class ReportadorNew extends Component
{
    public $nombre, $cc, $email;

    protected $rules = [
        'nombre' => 'required',
        'cc' => 'required|unique:reportadors',
        'email' => 'required|email|unique:reportadors'
    ];

    public function render()
    {
        return view('livewire.reportador.reportador-new');
    }

    public function guardar()
    {
        $this->validate();

        $datos = [
            'nombre' => $this->nombre,
            'cc' => $this->cc,
            'email' => $this->email
        ];

        Reportador::create($datos);
        $this->reset();
        $this->dispatch('ok_reportador');
        $this->dispatch('render');
    }

    public function resetear()
    {
        $this->nombre ='';
        $this->cc ='';
        $this->email ='';
    }
}
