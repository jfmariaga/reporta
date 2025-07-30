<?php

namespace App\Livewire\Panal;

use App\Models\Panal;
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
        $areas = Panal::where(function ($query) {
            return $query->where('area', 'LIKE', '%' . $this->search . '%');
        })
            ->paginate(10);
        return view('livewire.panal.index',compact('areas'));
    }

    public function selecItem($item, $action)
    {
        $this->item = $item;

        if ($action == 'editar') {
            $this->dispatch('getModelId', $this->item)->to(PanalEdit::class);
        }
    }
}
