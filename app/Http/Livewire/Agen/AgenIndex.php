<?php

namespace App\Http\Livewire\Agen;

use App\Models\Profile;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AgenIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public $limit = 10;
    public $search;
    public $isActive;

    protected $queryString = [
        'search' => ['except' => ''],
        'isActive' => ['except' => false]
    ];

    public $confirmationDelete;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingIsActive()
    {
        $this->resetPage();
    }

    public function confirmDelete(string $kode_agen)
    {
        $this->confirmationDelete = $kode_agen;
    }

    public function render()
    {
        $dataAgen = User::agen()->pencarian($this->search)->paginate($this->limit);

        return view('livewire.agen.agen-index', compact('dataAgen'));
    }
}
