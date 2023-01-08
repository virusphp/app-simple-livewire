<?php

namespace App\Http\Livewire\Master\Tarif;

use App\Models\District;
use App\Models\GudangHub;
use App\Models\Regency;
use App\Models\TarifLokal;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class TarifHubIndex extends Component
{
    use WithPagination;

    public $tarif;

    public $search;
    public $limit = 10; 

    // public $district_id, $regency_id, $nama_gudang, $tarif_lokal;

    public $selectedGudang = NULL;

    public $confirmationDelete;
    public $confirmationAdd = false;

    protected $rules = [
        'tarif.district_id' => 'required',
        'tarif.regency_id' => 'required',
        'tarif.nama_gudang' => 'required',
        'tarif.tarif_lokal' => 'required',
    ];

    public function getKecamatanAgenProperty()
    {
        return User::agen()
            ->join('profiles', 'profiles.kode_agen','=','users.kode_agen')
            ->select('profiles.district_id as kode', 'profiles.nama_agen as nama')
            ->get();
    }

    public function getGudangHubProperty()
    {
        return GudangHub::select('regency_id as kode', 'nama_gudang as nama')->get();
    }

    public function confirmAdd()
    {
        $this->reset(['tarif', 'selectedGudang']);
        $this->confirmationAdd = true;
    }

    public function updatedSelectedGudang($gudang)
    {
        if (isset($gudang)) {
            $this->tarif['regency_id'] = $gudang;
            $namaGudang = GudangHub::select('nama_gudang')->where('regency_id', $gudang)->first()->nama_gudang;
            $this->tarif['nama_gudang'] = $namaGudang;
        }
    }

    public function confirmEdit(TarifLokal $tarif)
    {
        $this->tarif = $tarif;
        $this->selectedGudang = $tarif->regency_id;
        $this->confirmationAdd = true;
    }

    public function confirmDelete(string $id)
    {
        $this->confirmationDelete = $id;
    }

    public function saveTarifHub()
    {
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
