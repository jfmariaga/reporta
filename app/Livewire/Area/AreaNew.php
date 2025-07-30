<?php

namespace App\Livewire\Area;

use App\Models\Area;
use App\Models\Panal;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AreaNew extends Component
{
    public $area, $localicacion, $cargo, $search;

    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected $rules = [
        'localicacion' => 'required|max:50',
        'area' => 'required|max:50',
    ];
    #[On('render')]
    public function render()
    {
        $areasUnicas = Panal::orderBy('area')->get();
        $areas = Area::where(function ($query) {
            return $query->where('area', 'LIKE', '%' . $this->search . '%')
            ->orWhere('localicacion', 'LIKE', '%' . $this->search . '%');
        })
            ->paginate(5);
        return view('livewire.area.area-new', compact('areasUnicas', 'areas'));
    }

    public function guardar()
    {
        $this->validate();

        $datos = [
            "localicacion" => $this->localicacion,
            "area" => $this->area
        ];

        Area::create($datos);
        $this->reset();
        $this->resetValidation();
        $this->dispatch('ok_area');
        $this->dispatch('render');
    }

    public function resetear()
    {
        $this->resetValidation(['area', 'localicacion']);
    }
}
