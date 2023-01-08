<?php

namespace App\Http\Livewire\Agen;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AgenIndex extends Component
{
    use WithPagination;

    public $user;

    protected $paginationTheme = 'tailwind';
    public $limit = 10;
    public $search;
    public $isActive;

    protected $queryString = [
        'search' => ['except' => ''],
        'isActive' => ['except' => false]
    ];

    public $confirmationDelete;
    public $confirmationAdd = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingIsActive()
    {
        $this->resetPage();
    }

    public function confirmAdd()
    {
    //     // $this->reset(['user']);
        $this->confirmationAdd = true;
    }

    // public function confirmEdit(User $user)
    // {
    //     $this->user = $user;
    //     $this->confirmationAdd = true;
    // }

    public function confirmDelete(string $kode_agen)
    {
        $this->confirmationDelete = $kode_agen;
    }

    public function deleteAgen(User $user)
    {
        if (!$user->transaksi && !$user->topup) {
            if ($user->saldo) {
                $user->saldo->delete();
            }
            $user->delete();
            $this->confirmationDelete = false;
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Agen berhasil di hapus!']);
        }
        $this->confirmationDelete = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'info', 'message' => 'Agen tidak bisa di hapus karena ada transaksi!']);
    }

    public function render()
    {
        $dataAgen = User::agen()->pencarian($this->search)->paginate($this->limit);

        return view('livewire.agen.agen-index', compact('dataAgen'));
    }
}
