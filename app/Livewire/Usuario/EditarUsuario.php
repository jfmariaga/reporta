<?php

namespace App\Livewire\Usuario;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class EditarUsuario extends Component
{
    public $modelId,$name, $email, $role_id;

    protected $listeners=['getModelId'];

    protected $rules = [
        'name' => 'required',
        'email' => 'required',
        'role_id' => 'required',
    ];

    public function render()
    {
        $roles = Role::first()
        ->take(3)
        ->get();
        return view('livewire.usuario.editar-usuario',compact('roles'));
    }

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model = User::find($this->modelId);
        $this->name = $model->name;
        $this->email = $model->email;
        $this->role_id= $model->roles[0]->id;

    }

    public function update()
    {

        $this->validate();

        $user = User::find($this->modelId);
        $user->roles()->sync($this->role_id);
        $user->name =  $this->name;
        $user->email = $this->email;
        $user->update();

        $this->dispatch('render')->to(Usuario::class);
        $this->reset();
        $this->dispatch('editar');
    }

    public function resetear()
    {
        $this->reset();
    }
}
