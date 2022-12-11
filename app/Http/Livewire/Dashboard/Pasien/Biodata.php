<?php

namespace App\Http\Livewire\Dashboard\Pasien;

use App\Models\Pasien;
use Livewire\Component;
use Livewire\WithPagination;

class Biodata extends Component
{
    use  WithPagination;

    public function render()
    {
        $pasien = Pasien::paginate(25);
        return view('livewire.dashboard.pasien.biodata', compact('pasien'));
    }
}
    