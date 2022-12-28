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
        'negara.nama_negara' => 'requried'
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
        dd($this->negara);
        $this->validation();

    }

    public function render()
    {
        $dataCountry = Country::pencarian($this->search)->paginate($this->limit);
        return view('livewire.master.country.countries-index', compact('dataCountry'));
    }
}
