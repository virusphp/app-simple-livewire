<?php

namespace App\Http\Livewire\Master\Tarif;

use App\Models\District;
use App\Models\Regency;
use App\Models\TarifLokal;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TarifHubIndex extends Component
{
    use WithPagination;

    public $tarif;

    public $search;
    public $limit = 10; 

    public $regencies;
    public $districts;

    public $selectedRegency = NULL;

    public $confirmationDelete;
    public $confirmationAdd = false;

    protected $rules = [
        'selectedRegency' => 'required',
        'tarif.district_id' => 'nullable|string',
        'tarif.nama_gudang' => 'required',
        'tarif.tarif_lokal' => 'required',
    ];

    public function mount()
    {
        $this->regencies = Regency::select('id','name')->get();
        $this->districts = collect();
    }

    public function updatedSelectedRegency($regency)
    {
        if (!is_null($regency)) {
            $this->districts = District::select('id','name')->where('regency_id', $regency)->get();
        }
    }

    public function confirmAdd()
    {
        $this->reset(['tarif']);
        $this->confirmationAdd = true;
    }

    public function confirmEdit(TarifLokal $tarif)
    {
        $this->tarif = $tarif;
        $this->selectedRegency = $this->tarif['regency_id'];
         if (!is_null($this->selectedRegency)) {
            $this->districts = District::select('id','name')->where('regency_id', $this->selectedRegency)->get();
        }
        $this->confirmationAdd = true;
    }

    public function confirmDelete(string $id)
    {
        $this->confirmationDelete = $id;
    }

    public function saveTarifHub()
    {
        // dd($this->tarif);
        $this->validate();
        if(isset($this->tarif->id)) {
            $this->tarif->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master tarif berhasil di update!']);
        } else {
            Auth()->user()->tarifLokal()->create($this->tarif);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master tarif berhasil di tambah!']);
        }
        $this->confirmationAdd = false;

    }

    public function deleteTarifHub(TarifLokal $tarif)
    {
        $tarif->delete();
        $this->confirmationDelete = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master tarif berhasil di hapus!']);
    }

    public function render()
    {
        $dataTarifHub = TarifLokal::pencarian($this->search)->latest()->paginate($this->limit);
        return view('livewire.master.tarif.tarif-hub-index', compact('dataTarifHub'));
    }
}
