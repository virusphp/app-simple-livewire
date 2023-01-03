<?php

namespace App\Http\Livewire\Master\Tarif;

use App\Models\TarifLokal;
use Livewire\Component;
use Livewire\WithPagination;

class TarifHub extends Component
{
    use WithPagination;

    public $tarif;

    public $search;
    public $limit = 10; 

    public $confirmationDelete;
    public $confirmationAdd = false;

    protected $rules = [
        'tarif.district_id' => 'required',
        'tarif.regency_id' => 'required',
        'tarif.nama_gudang' => 'required',
        'tarif.tarif_lokal' => 'required',
    ];

    public function confirmAdd()
    {
        $this->reset(['tarif']);
        $this->confirmationAdd = true;
    }

    public function confirmEdit(TarifLokal $tarif)
    {
        $this->tarif = $tarif;
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
            tarifHub::create($this->tarif);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master tarif berhasil di tambah!']);
        }
        $this->confirmationAdd = false;

    }

    public function deleteTarifHub(TarifLokal $tarif)
    {
        // if ($tarif->tarif()->count() != 0) {
        //     $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'Master tarif tidak bisa di hapus!']);
        //     return false;
        // }
        $tarif->delete();
        $this->confirmationDelete = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master tarif berhasil di hapus!']);
    }

    public function render()
    {
        return view('livewire.master.tarif.tarif-hub');
    }
}
