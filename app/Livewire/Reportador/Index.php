<?php

namespace App\Livewire\Reportador;

use App\Models\Reportador;
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
        $reportadores = Reportador::where(function ($query) {
            return $query->where('nombre', 'LIKE', '%' . $this->search . '%')
                ->orWhere('cc', 'LIKE', '%' . $this->search . '%')
                ->orWhere('email', 'LIKE', '%' . $this->search . '%');
        })
            ->paginate(10);
        return view('livewire.reportador.index', compact('reportadores'));
    }

    public function selecItem($item, $action)
    {
        $this->item = $item;

        if ($action == 'editar') {
            $this->dispatch('getModelId', $this->item)->to(ReportadorEdit::class);
        }
    }
}
