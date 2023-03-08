<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Master Tarif Paket') }}
    </h2>
</x-slot>

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2 sm:px-10 bg-white border-b border-gray-200 ">
                <div class="mt-2 text-2xl font-bold uppercase flex justify-between">
                    <div>
                        Master Tarif Paket
                    </div>
                    <div class="mr-2">
                        <x-jet-button wire:click="confirmAdd" class="bg-blue-500 hover:bg-blue-700">
                            Tambah Tarif Paket
                        </x-jet-button>
                    </div>
                </div>

                {{-- {{ $query }} --}}

                <div class="mt-2 text-gray-500">
                    <div class="flex justify-end py-2">
                        <div class="mr-2">
                            <input type="search" wire:model="search" placeholder="Search..."
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-600 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                    </div>
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse border">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th rowspan="2" scope="col" class="py-3 px-3">
                                        KODE
                                    </th>
                                    <th rowspan="2" scope="col" class="py-3 px-3">
                                        NEGARA TUJUAN
                                    </th>
                                    <th rowspan="2" scope="col" class="py-3 px-3">
                                        JENIS PAKET
                                    </th>
                                    <th colspan="2" scope="col" class="py-3 px-3">
                                        (KG) PERTAMA
                                    </th>
                                    <th colspan="2" scope="col" class="py-3 px-3">
                                        (KG) SELANJUTNYA
                                    </th>
                                    <th colspan="2" scope="col" class="py-3 px-3">
                                        (KG) LEBIH DARI
                                    </th>
                                   <th rowspan="2" scope="col" class="py-3 px-3">
                                        AKSI 
                                    </th>
                                </tr>
                                <tr>
                                    <th scope="col" class="py-3 px-3">
                                        BERAT 
                                    </th>
                                    <th scope="col" class="py-3 px-3">
                                        TARIF
                                    </th>
                                    <th scope="col" class="py-3 px-3">
                                        BERAT 
                                    </th>
                                    <th scope="col" class="py-3 px-3">
                                        TARIF
                                    </th>
                                    <th scope="col" class="py-3 px-3">
                                        BERAT 
                                    </th>
                                    <th scope="col" class="py-3 px-3">
                                        TARIF 
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataTarifs as $key => $val)
                                {{-- {{ dd($val[$key]) }} --}}
                                <tr
                                    class="bg-white border-b hover:bg-gray-50">
                                    <td class="py-3 px-3">
                                        {{ $val['kode_negara'] }}
                                    </td>
                                    <td class="py-3 px-3">
                                        {{ $val['nama_negara'] }}
                                    </td>
                                    <td class="py-3 px-3">
                                        {{ $val['jenis_paket'] }}
                                    </td>
                                    <td class="py-3 px-3">
                                        {{ $val['berat1'] }}
                                    </td>
                                    <td class="py-3 px-3">
                                        {{ rupiah($val['tarif1']) }}
                                    </td>
                                    <td class="py-3 px-3">
                                        {{ $val['berat2'] }}
                                    </td>
                                    <td class="py-3 px-3">
                                        {{ rupiah($val['tarif2']) }}
                                    </td>
                                    <td class="py-3 px-3">
                                        {{ $val['berat3'] }}
                                    </td>
                                    <td class="py-3 px-3">
                                        {{ rupiah($val['tarif3']) }}
                                    </td>
                                    <td class="text-right flex items-end">
                                        <x-jet-button wire:click="confirmEdit('{{ $val['kode_negara'] }}')"
                                            class="bg-orange-500 hover:bg-orange-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </x-jet-button>
                                        <x-jet-danger-button class="ml-1"
                                            wire:click="confirmDelete('{{ $val['kode_negara'] }}')"
                                            wire:loading.attr="disabled">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </x-jet-danger-button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="py-3">
                        {{ $dataTarifs->appends(['search' => 'search'])->render() }}
                    </div>

                    {{-- Model Confirmasi Delete --}}
                    <x-jet-dialog-modal wire:model="confirmationDelete">
                        <x-slot name="title">
                            {{ __('Delete tarif') }}
                        </x-slot>

                        <x-slot name="content">
                            {{ __('Are you sure you want to delete your tarif hub?') }}
                        </x-slot>

                        <x-slot name="footer">
                            <x-jet-secondary-button wire:click="$set('confirmationDelete', false)"
                                wire:loading.attr="disabled">
                                {{ __('Cancel') }}
                            </x-jet-secondary-button>

                            <x-jet-danger-button class="ml-3" wire:click="deleteTarifHub('{{$confirmationDelete}}')"
                                wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-jet-danger-button>
                        </x-slot>
                    </x-jet-dialog-modal>

                    {{-- Model Confirmasi Add --}}
                    <x-jet-dialog-modal wire:model="confirmationAdd">
                        <x-slot name="title">
                            {{ __('Tambah Tarif Hub') }}
                        </x-slot>

                        <x-slot name="content">
                            <div class="col-span-6 sm:col-span-4 mt-2 {{ isset($this->tarif->id) ? 'hidden' : 'hidden'}}">
                                <x-jet-label for="kode_tarif" value="{{ __('Kode Tarif Hub') }}" />
                                <x-jet-input id="kode-tarif" type="text" class="mt-1 block w-full"
                                    wire:model.defer="tarif.kode_tarif"/>
                                <x-jet-input-error for="tarif.kode_tarif" class="mt-2" />
                            </div>
                            <div class="col-span-6 sm:col-span-4 mt-2">
                                <x-jet-label for="selectedCountry" value="{{ __('Negara tujuan') }}" />
                                <x-select-search :data="$this->countries" wire:model="selectedCountry" placeholder="Select negara!"/>
                                <x-jet-input-error for="selectedJenisPaket" class="mt-2" />
                            </div>
                            <div class="col-span-6 sm:col-span-4 mt-2">
                                <x-jet-label for="selectedJenisPaket" value="{{ __('Jenis Paket') }}" />
                                <x-select-search :data="$this->jenisPaket" wire:model="selectedJenisPaket" placeholder="Select jenis paket!"/>
                                <x-jet-input-error for="selectedJenisPaket" class="mt-2" />
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-8 mt-2">
                                <div class="relative z-0 mb-1 w-48 group">
                                    <x-jet-label for="kg_pertama" value="{{ __('Kg Pertama') }}" />
                                    <x-jet-input id="kd-pertama" type="text" class="mt-0 text-xs block w-full"
                                        wire:model.defer="tarif.0.berat" value="1" readonly/>
                                    <input type="hidden" wire:model="tarif.0.nama_negara">
                                    <input type="hidden" wire:model="tarif.0.kode_negara">
                                    <input type="hidden" wire:model="tarif.0.kode_jenis">
                                    <x-jet-input-error for="tarif.0.berat" class="mt-0" />
                                </div>
            
                                <div class="relative z-0 mb-1 w-full group">
                                    <x-jet-label for="tarif" value="{{ __('Tarif Umum') }}" />
                                    <x-jet-input id="tarif-tarif" type="text" class="mt-0 text-xs block w-full"
                                        wire:model.defer="tarif.0.tarif" />
                                    <x-jet-input-error for="tarif.0.tarif" class="mt-0" />
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-8 mt-2">
                                <div class="relative z-0 mb-1 w-48 group">
                                    <x-jet-label for="kg_pertama" value="{{ __('Kg Selanjutnya') }}" />
                                    <x-jet-input id="kd-pertama" type="text" class="mt-0 text-xs block w-full"
                                        wire:model.defer="tarif.1.berat" value="2" readonly/>
                                    <input type="hidden" wire:model="tarif.1.nama_negara">
                                    <input type="hidden" wire:model="tarif.1.kode_negara">
                                    <input type="hidden" wire:model="tarif.1.kode_jenis">
                                    <x-jet-input-error for="tarif.1.berat" class="mt-0" />
                                </div>
            
                                <div class="relative z-0 mb-1 w-full group">
                                    <x-jet-label for="tarif" value="{{ __('Tarif Umum') }}" />
                                    <x-jet-input id="tarif-tarif" type="text" class="mt-0 text-xs block w-full"
                                        wire:model.defer="tarif.1.tarif" />
                                    <x-jet-input-error for="tarif.1.tarif" class="mt-0" />
                                </div>
                            </div>
                            <div class="grid md:grid-cols-2 md:gap-8 mt-2">
                                <div class="relative z-0 mb-1 w-48 group">
                                    <x-jet-label for="kg_pertama" value="{{ __('Kg Lebih dari') }}" />
                                    <x-jet-input id="kd-pertama" type="text" class="mt-0 text-xs block w-full"
                                        wire:model.defer="tarif.2.berat" value="31" readonly/>
                                    <input type="hidden" wire:model="tarif.2.nama_negara">
                                    <input type="hidden" wire:model="tarif.2.kode_negara">
                                    <input type="hidden" wire:model="tarif.2.kode_jenis">
                                    <x-jet-input-error for="tarif.2.berat" class="mt-0" />
                                </div>
            
                                <div class="relative z-0 mb-1 w-full group">
                                    <x-jet-label for="tarif" value="{{ __('Tarif Umum') }}" />
                                    <x-jet-input id="tarif-tarif" type="text" class="mt-0 text-xs block w-full"
                                        wire:model.defer="tarif.2.tarif" />
                                    <x-jet-input-error for="tarif.2.tarif" class="mt-0" />
                                </div>
                            </div>

                        </x-slot>
                        
                        <x-slot name="footer">
                            <x-jet-secondary-button wire:click="$set('confirmationAdd', false)"
                                wire:loading.attr="disabled">
                                {{ __('Cancel') }}
                            </x-jet-secondary-button>

                            <x-jet-danger-button class="ml-3" wire:click="saveTarifPaket()" wire:loading.attr="disabled">
                                {{ __('Save') }}
                            </x-jet-danger-button>
                        </x-slot>
                    </x-jet-dialog-modal>
                </div>
            </div>
        </div>
    </div>
</div>