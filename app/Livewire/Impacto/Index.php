<?php

namespace App\Livewire\Impacto;

use App\Models\Impacto;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $search, $item;
    public function updatingSearch()
    {
        $this->resetPage();
    }
    protected $listeners = ['render'];

    public function render()
    {
        $impactos = Impacto::where(function ($query) {
            return $query->where('impacto', 'LIKE', '%' . $this->search . '%');
        })
            ->paginate(10);
        return view('livewire.impacto.index', compact('impactos'));
    }

    public function selecItem($item, $action)
    {
        $this->item = $item;

        if ($action == 'editar') {
            $this->dispatch('getModelId', $this->item)->to(ImpactoEdit::class);
        }
    }
}
