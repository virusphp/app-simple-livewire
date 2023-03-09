<?php

namespace App\Http\Livewire\Master\Tarif;

use App\Models\Country;
use App\Models\JenisPaket;
use App\Models\Tarif;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class TarifPaketIndex extends Component
{
    use WithPagination;

    public $tarif;

    public $search;
    public $limit = 10;

    public $selectedJenis;

    public $selectedCountry = NULL;
    public $selectedJenisPaket = NULL;

    public $confirmationDelete;
    public $confirmationAdd = false;

    protected $rules = [
        'selectedCountry' => 'required',

        'tarif.0.kode_jenis' => 'required',
        'tarif.0.kode_negara' => 'required',
        'tarif.0.berat' => 'required',
        'tarif.0.tarif' => 'required',

        'tarif.1.kode_jenis' => 'required',
        'tarif.1.kode_negara' => 'required',
        'tarif.1.berat' => 'required',
        'tarif.1.tarif' => 'required',

        'tarif.2.kode_jenis' => 'required',
        'tarif.2.kode_negara' => 'required',
        'tarif.2.berat' => 'required',
        'tarif.2.tarif' => 'required',
    ];

    public function getCountriesProperty()
    {
        return Country::pluck('nama_negara as nama','kode_negara as id');
    }

    public function getJenisPaketProperty()
    {
        return JenisPaket::pluck('nama_jenis_paket as nama', 'kode_jenis as id');
    }

    public function mount()
    {
        $this->jenis = JenisPaket::pluck('nama_jenis_paket as nama', 'kode_jenis as id');
    }

    public function updatedSelectdJenis()
    {
        $this->resetPage();
    }

    public function updatedSelectedCountry($country)
    {
       if (!empty($country)) {
            $dataCountry = Country::select('nama_negara')->where('kode_negara', $country)->first();
            $this->tarif[0]['kode_negara'] = $country;
            $this->tarif[0]['nama_negara'] = $dataCountry->nama_negara;
            $this->tarif[1]['kode_negara'] = $country;
            $this->tarif[1]['nama_negara'] = $dataCountry->nama_negara;
            $this->tarif[2]['kode_negara'] = $country;
            $this->tarif[2]['nama_negara'] = $dataCountry->nama_negara;
       }
    }

    public function updatedSelectedJenisPaket($paket)
    {
        $this->tarif[0]['kode_jenis'] = $paket;
        $this->tarif[1]['kode_jenis'] = $paket;
        $this->tarif[2]['kode_jenis'] = $paket;
        
        $this->tarif[0]['user_id'] = Auth::user()->id;
        $this->tarif[1]['user_id'] = Auth::user()->id;
        $this->tarif[2]['user_id'] = Auth::user()->id;

    }

    public function confirmAdd()
    {
        $this->reset(['tarif']);
        $this->tarif[0]['berat'] = 1;
        $this->tarif[1]['berat'] = 2;
        $this->tarif[2]['berat'] = 31;
        $this->confirmationAdd = true;
    }

    public function confirmEdit(Tarif $tarif)
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

    public function saveTarifPaket()
    {
        $this->validate();
        // dd($this->tarif[0]['kode_negara']);
        if(isset($this->tarif->id)) {
            $this->tarif->save();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master tarif berhasil di update!']);
        } else {
            Auth()->user()->tarif()->createMany($this->tarif);
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master tarif berhasil di tambah!']);
        }
        $this->confirmationAdd = false;
    }

    protected function handleRequest($params)
    {
        $data = [];
        foreach ($params as $val) {
            // dd($val['berat'], $val['tarif'], $params['kode_jenis']);
            $data[] = [
                'kode_negara' => $params['kode_negara'],
                'nama_negara' => strtoupper($params['nama_negara']),
                'kode_jenis' => $params['kode_jenis'],
                'berat' => $val['berat'],
                'tarifs' => $val['tarif'],
                'user_id' => Auth::user()->id,
            ];
        }
        return $data;
    }

    public function deleteTarifHub(TarifLokal $tarif)
    {
        $tarif->delete();
        $this->confirmationDelete = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Master tarif berhasil di hapus!']);
    }

    public function render()
    {
        $dataTarif = Tarif::select(
            'tarifs.id', 
            'tarifs.kode_negara', 
            'tarifs.nama_negara', 
            'tarifs.kode_jenis', 
            'tarifs.berat',  
            'tarifs.tarif', 
            'tarifs.user_id', 
            'jp.nama_jenis_paket')
            ->join('jenis_pakets as jp', 'tarifs.kode_jenis','jp.kode_jenis')
            ->orderBy('tarifs.nama_negara', 'ASC')
            ->orderBy('tarifs.berat', 'ASC')
            ->where('tarifs.kode_jenis', '=',  $this->selectedJenis)
            ->pencarian($this->search)
            ->get();

            // dd($dataTarif, $this->jenis);
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

        $tarifs = [];
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