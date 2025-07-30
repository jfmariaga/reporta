<?php

namespace App\Livewire\Usuario;

use App\Models\User;
use Livewire\Component;

class Usuario extends Component
{ public $item,$action;

    protected $listeners=['render'];
    public function render()
    {
        $usuarios = User::role(['admin','JefeArea','JefeImpacto'])
        ->get();
        return view('livewire.usuario.usuario',compact('usuarios'));
    }

    public function selecItem($userId, $action)
    {
        $this->item = $userId;

        if ($action == 'delete') {
           $this->emit('delete_ok');
        } else {
            $this->dispatch('getModelId', $this->item)->to(EditarUsuario::class);
        }
    }
}
