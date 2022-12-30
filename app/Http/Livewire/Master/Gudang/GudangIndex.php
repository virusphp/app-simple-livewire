<?php

namespace App\Http\Livewire\Master\Gudang;

use App\Models\GudangHub;
use Livewire\Component;
use Livewire\WithPagination;

class GudangIndex extends Component
{
    use WithPagination;

    public $gudang;

    public $search;
    public $limit = 10; 

    public $confirmationDelete;
    public $confirmationAdd = false;

    protected $rules = [
        'gudang.kode_gudang' => 'required',
        'gudang.nama_gudang' => 'required',
        'gudang.regency_id' => 'required'
    ];

    public function confirmAdd()
    {
        $this->reset(['gudang']);
        $this->confirmationAdd = true;
    }

    public function confirmEdit(GudangHub $gudang)
    {
        $this->gudang = $gudang;
        $this->confirmationAdd = true;
    }

    public function confirmDelete(string $kode_gudang)
    {
        $this->confirmationDelete = $kode_gudang;
    }

    public function saveGudang()
    {
        $this->validate();
        if(isset($this->gudang->kode_gudang)) {
            $this->gudang->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master gudang berhasil di update!']);
        } else {
            Country::create($this->gudang);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master gudang berhasil di tambah!']);
        }
        $this->confirmationAdd = false;

    }

    public function deletegudangPaket(gudangPaket $gudang)
    {
        // if ($gudang->tarif()->count() != 0) {
        //     $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'Master gudang tidak bisa di hapus!']);
        //     return false;
        // }
        $gudang->delete();
        $this->confirmationDelete = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master gudang berhasil di hapus!']);
    }

    public function render()
    {
        $dataGudang = GudangHub::pencarian($this->search)->latest()->paginate($this->limit);
        return view('livewire.master.gudang.gudang-index', compact('dataGudang'));
    }
}
