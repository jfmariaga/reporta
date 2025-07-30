<?php

namespace App\Livewire\Reporte;

use App\Mail\Reportador as MailReportador;
use App\Mail\Reporte as MailReporte;
use App\Mail\ReporteImpacto;
use App\Models\Area;
use App\Models\Cargo;
use App\Models\Gestion;
use App\Models\HistorialReporte;
use App\Models\Impacto;
use App\Models\Panal;
use App\Models\Reportador;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;



class CreateReporte extends Component
{
    use WithFileUploads;

    public $area, $search, $cargos, $panal, $cargo, $zona, $zonas = null, $nombre, $impacto = [], $descripcion, $orden, $prioridad, $img, $identificar, $responsable, $consecutivo, $userName, $userEmail, $reporEmail;
    public $idSearch;
    protected $listeners = ['render'];
    protected $rules = [
        'area' => 'required',
        'cargo' => 'required',
        'zona' => 'required',
        'nombre' => 'required',
        'reporEmail' => 'required',
        'panal' => 'required',
        'impacto' => 'required',
        'descripcion' => 'required',
        'prioridad' => 'required',
        'img' => 'required',
        'search' => 'required',
    ];

    public function render()
    {

        $areas = Area::all();
        $areasUnicas = $areas->unique('area');
        // $cargos = Cargo::all();
        $impactos = Impacto::all();

        if (!is_null($this->area)) {
            $this->zonas = Area::where('area', $this->area)->get();
        }

        $panals = Panal::orderBy('area')->get();
        if (!is_null($this->panal)) {
            $this->cargos = Cargo::where('area', $this->panal)->get();
        }

        $empleado = [];
        $empleado = Reportador::where('cc', $this->search)->get();
        if (count($empleado) > 0) {
            $this->nombre = $empleado[0]->nombre;
            $this->reporEmail = $empleado[0]->email;
            $this->idSearch = $empleado[0]->id;
        }

        return view('livewire.reporte.create-reporte', compact('areasUnicas', 'impactos', 'panals', 'empleado'));
    }

    public  function guardar()
    {
        $this->validate();
        $url =  $this->img->store('public/adjunto');

        $this->consecutivo = 'REG' . date('m') . date('d') . Str::random(3);

        $resArea = Gestion::where('area', $this->area)->get();

        foreach ($resArea as $item) {
            $this->responsable = $item->user_id;
        }

        $datos = [
            'area' => $this->area,
            'cargo_id' => $this->cargo,
            'zona' => $this->zona,
            'ReportadoPor' => $this->nombre,
            'impactos' => json_encode($this->impacto),
            'descripcion' => $this->descripcion,
            'prioridad' => $this->prioridad,
            'areaTrabajo' => $this->panal,
            'adjunto' => $url,
            'orden' => $this->orden,
            'estado' => '1',
            'consecutivo' => $this->consecutivo,
            'responsable_id' => $this->responsable,
            'email' => $this->reporEmail
        ];
        $repornew =  Reporte::create($datos);

        $users = User::where('id', $this->responsable)->get();
        foreach ($users as $item) {
            $this->userName = $item->name;
            $this->userEmail = $item->email;
        }
        //correo para el jefe del area
        Mail::to($this->userEmail)->queue(new MailReporte($datos));

        //correo para la persona que reporta
        Mail::to($this->reporEmail)->queue(new MailReportador($datos));

        //envia el correo de notificacion a las areas de impacto
        foreach ($this->impacto as $i) {
            $id = $i;
            $impactoLocal = Impacto::where('id', $id)->get();
            foreach ($impactoLocal as $item) {
                $idUser = $item->user_id;
                $users = User::where('id', $idUser)->get();
                foreach ($users as $item) {
                    $this->userEmail = $item->email;
                }
                Mail::to($this->userEmail)->queue(new ReporteImpacto($datos));
            }
        }
        $reportador = User::where('name','Generico')->get();
        foreach ($reportador as $key) {
            $idRepor = $key->id;
        }
        // Registrar en el historial
        HistorialReporte::create([
            'reporte_id' => $repornew->id,
            'user_id' => $idRepor,
            'accion' => 'Pendiente',
            'detalle' => 'Reporte creado con exito',
        ]);
        $this->reset();
        $this->dispatch('ok_reporte');
        $this->resetValidation();
        $this->dispatch('render');
    }

    public function mount()
    {
        $this->identificar =  rand();
    }

    public function resetear()
    {
        $this->reset();
        $this->identificar =  rand();
    }
}
