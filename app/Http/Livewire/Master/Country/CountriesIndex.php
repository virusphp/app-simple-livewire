<?php

namespace App\Http\Livewire\Master\Country;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;

class CountriesIndex extends Component
{

    use WithPagination;

    public $negara;

    public $search;
    public $limit = 10;

    public $confirmationDelete;
    public $confirmationAdd = false;

    protected $rules = [
        'negara.kode_negara' => 'required',
        'negara.nama_negara' => 'required'
    ];

    public function confirmAdd()
    {
        $this->reset(['negara']);
        $this->confirmationAdd = true;
    }

    public function confirmEdit(Country $negara)
    {
        $this->negara = $negara;
        $this->confirmationAdd = true;
    }

    public function confirmDelete(string $kode_negara)
    {
        $this->confirmationDelete = $kode_negara;
    }
    
    public function saveNegara()
    {
        $this->validate();
        if(isset($this->negara->kode_negara)) {
            $this->negara->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master negara berhasil di update!']);
        } else {
            Country::create($this->negara);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master negara berhasil di tambah!']);
        }
        $this->confirmationAdd = false;

    }

    public function deleteNegara(Country $negara)
    {
        if ($negara->tarif()->count() != 0) {
            $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'Master negara tidak bisa di hapus!']);
            return false;
        }
        $negara->delete();
        $this->confirmationDelete = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master negara berhasil di hapus!']);
    }

    public function render()
    {
        $dataCountry = Country::pencarian($this->search)->latest()->paginate($this->limit);
        return view('livewire.master.country.countries-index', compact('dataCountry'));
    }
}
