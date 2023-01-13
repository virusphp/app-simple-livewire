<?php

namespace App\Http\Livewire\Master\Tarif;

use App\Models\Country;
use App\Models\JenisPaket;
use App\Models\Tarif;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class TarifPaketIndex extends Component
{
    use WithPagination;

    public $tarif;

    public $search;
    public $limit = 10; 

    public $selectedCountry = NULL;
    public $selectedJenisPaket = NULL;

    public $confirmationDelete;
    public $confirmationAdd = false;

    protected $rules = [
        'selectedCountry' => 'required',
        'tarif.nama_negara' => 'required',
        'tarif.kode_jenis' => 'nullable|string',
        'tarif.berat_pertama' => 'string',
        'tarif.berat_kedua' => 'required',
        'tarif.berat_ketiga' => 'required',
        'tarif.tarif_pertama' => 'required',
        'tarif.tarif_' => 'required',
    ];

    public function getCountriesProperty()
    {
        return Country::pluck('nama_negara as nama','kode_negara as id');
    }

    public function getJenisPaketProperty()
    {
        return JenisPaket::pluck('nama_jenis_paket as nama', 'kode_jenis as id');
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
        $dataTarif = Tarif::select('tarifs.kode_negara','tarifs.nama_negara','jp.kode_jenis','jp.nama_jenis_paket','tarifs.berat','tarifs.tarif')
            ->join('jenis_pakets as jp', 'tarifs.kode_jenis','jp.kode_jenis')
            ->pencarian($this->search)->get();
        $dataTarifs = $this->handleMap($dataTarif);
        // dd($dataTarifs);
        return view('livewire.master.tarif.tarif-paket-index', compact('dataTarifs'));
    }

    protected function handleMap($params)
    {
        $data = [];
        foreach ($params as $value) {
            $data[$value->kode_negara]['kode_negara'] = $value->kode_negara;
            $data[$value->kode_negara]['nama_negara'] = $value->nama_negara;
            $data[$value->kode_negara]['kode_jenis'] = $value->kode_jenis;
            $data[$value->kode_negara]['jenis_paket'] = $value->nama_jenis_paket;
            $data[$value->kode_negara]['berat'][] = $value->berat;
            $data[$value->kode_negara]['tarif'][] = $value->tarif;
        }

        // $tarifs = [];
        foreach ($data as $key => $q) {
            $tarifs[$key] = [
            'kode_negara' => $q['kode_negara'],
            'nama_negara' => $q['nama_negara'],
            'kode_jenis' => $q['kode_jenis'],
            'jenis_paket' => $q['jenis_paket'],
            'berat1' => $q['berat'][0],
            'tarif1' => $q['tarif'][0],
            'berat2' => $q['berat'][1],
            'tarif2' => $q['tarif'][1],
            'berat3' => $q['berat'][2],
            'tarif3' => $q['tarif'][2],
            ];
        }

        $total = count($tarifs);
        $per_page = $this->limit;
        $current = Request()->input("page") ?? 1;
        $current_page = LengthAwarePaginator::resolveCurrentPage();
        $starting_point = ($current_page * $per_page) - $per_page;

        $array = array_slice($tarifs, $starting_point, $per_page, false);
        // dd(request()->query(), $array, $total, $per_page, $current_page);
        $array = new LengthAwarePaginator($array, $total, $per_page, $current, [
            'path' => Request()->url(),
            'pageName' => 'page'
        ]);

        return $array;
    
    }
}