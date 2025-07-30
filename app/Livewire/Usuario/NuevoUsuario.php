<?php

namespace App\Livewire\Usuario;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;


class NuevoUsuario extends Component
{
    public $name, $confiPassword, $email, $password, $role_id, $ver_contrasena, $type = 'password';
    public $user;
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'role_id' => 'required',
        'confiPassword' => 'required|min:8'
    ];
    public function render()
    {
        $roles = Role::first()
            ->take(3)
            ->get();
        return view('livewire.usuario.nuevo-usuario', compact('roles'));
    }

    public function guardar()
    {

        $this->validate();


        if ($this->password === $this->confiPassword) {
            $datos = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ];

            $user = User::create($datos);
            $user->assignRole($this->role_id);
            $user->save();
            $this->dispatch('render')->to(Usuario::class);
            $this->reset();
            $this->dispatch('usuario_ok');
        } else {
            $this->dispatch('contraseña');
        }
    }

    public function resetear()
    {
        $this->reset();
    }

    public function verContrasena()
    {
        if ($this->ver_contrasena == '1') {
            $this->type = 'text';
        } else {
            $this->type = 'password';
        }
    }
}
