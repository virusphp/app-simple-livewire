<?php

namespace App\Http\Livewire\Master\Jenis;

use App\Models\JenisPaket;
use Livewire\Component;
use Livewire\WithPagination;

class JenisIndex extends Component
{

    use WithPagination;

    public $jenis;

    public $search;
    public $limit = 10; 

    public $confirmationDelete;
    public $confirmationAdd = false;

    protected $rules = [
        'jenis.kode_jenis' => 'nullable|string',
        'jenis.nama_jenis_paket' => 'required'
    ];

    public function confirmAdd()
    {
        $this->reset(['jenis']);
        $this->confirmationAdd = true;
    }

    public function confirmEdit(JenisPaket $jenis)
    {
        $this->jenis = $jenis;
        $this->confirmationAdd = true;
    }

    public function confirmDelete(string $kode_jenis)
    {
        $this->confirmationDelete = $kode_jenis;
    }

    public function saveJenisPaket()
    {
        $this->validate();
        if(isset($this->jenis->kode_jenis)) {
            $this->jenis->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master jenis berhasil di update!']);
        } else {
            JenisPaket::create($this->jenis);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master jenis berhasil di tambah!']);
        }
        $this->confirmationAdd = false;

    }

    public function deleteJenisPaket(JenisPaket $jenis)
    {
        if ($jenis->tarif()->count() != 0) {
            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'Master Jenis tidak bisa di hapus!']);
            return false;
        }
        $jenis->delete();
        $this->confirmationDelete = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master Jenis berhasil di hapus!']);
    }

    public function render()
    {
        $dataJenis = JenisPaket::pencarian($this->search)->latest()->paginate($this->limit);
        return view('livewire.master.jenis.jenis-index', compact('dataJenis'));
    }
}
