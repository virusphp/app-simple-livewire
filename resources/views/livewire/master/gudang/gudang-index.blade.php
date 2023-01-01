<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Master Gudang Hub') }}
    </h2>
</x-slot>

<div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-2 sm:px-10 bg-white border-b border-gray-200 ">
                <div class="mt-2 text-2xl font-bold uppercase flex justify-between">
                    <div>
                        Master Gudang Hub
                    </div>
                    <div class="mr-2">
                        <x-jet-button wire:click="confirmAdd" class="bg-blue-500 hover:bg-blue-700">
                            Tambah Gudang Hub
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
                                    <th scope="col" class="py-3 px-6 font-bold">
                                        NO
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        KODE GUDANG
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        NAMA GUDANG
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        KOTA
                                    </th>
                                   <th scope="col" class="py-3 px-6">
                                        AKSI 
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataGudang as $val)
                                {{-- {{ dd($val) }} --}}
                                <tr
                                    class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row"
                                        class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </th>
                                    <td class="py-3 px-6">
                                        {{ $val->kode_gudang }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $val->nama_gudang }}
                                    </td>
                                    <td class="py-3 px-6">
                                        {{ $val->kota->name }}
                                    </td>
                                    <td class="text-right flex items-end">
                                        <x-jet-button wire:click="confirmEdit('{{ $val->kode_gudang }}')"
                                            class="bg-orange-500 hover:bg-orange-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </x-jet-button>
                                        <x-jet-danger-button class="ml-1"
                                            wire:click="confirmDelete('{{ $val->kode_gudang }}')"
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
                        {{ $dataGudang->appends(['search' => 'search'])->render() }}
                    </div>

                    {{-- Model Confirmasi Delete --}}
                    <x-jet-dialog-modal wire:model="confirmationDelete">
                        <x-slot name="title">
                            {{ __('Delete gudang') }}
                        </x-slot>

                        <x-slot name="content">
                            {{ __('Are you sure you want to delete your gudang hub?') }}
                        </x-slot>

                        <x-slot name="footer">
                            <x-jet-secondary-button wire:click="$set('confirmationDelete', false)"
                                wire:loading.attr="disabled">
                                {{ __('Cancel') }}
                            </x-jet-secondary-button>

                            <x-jet-danger-button class="ml-3" wire:click="deleteGudangHub('{{$confirmationDelete}}')"
                                wire:loading.attr="disabled">
                                {{ __('Delete') }}
                            </x-jet-danger-button>
                        </x-slot>
                    </x-jet-dialog-modal>

                    {{-- Model Confirmasi Add --}}
                    <x-jet-dialog-modal wire:model="confirmationAdd">
                        <x-slot name="title">
                            {{ __('Tambah Gudang Hub') }}
                        </x-slot>

                        <x-slot name="content">
                            <div class="col-span-6 sm:col-span-4 mt-2 {{ isset($this->gudang->kode_gudang) ? 'hidden' : 'hidden'}}">
                                <x-jet-label for="kode_gudang" value="{{ __('Kode Gudang Hub') }}" />
                                <x-jet-input id="kode-gudang" type="text" class="mt-1 block w-full"
                                    wire:model.defer="gudang.kode_gudang"/>
                                <x-jet-input-error for="gudang.kode_gudang" class="mt-2" />
                            </div>
                            <div class="col-span-6 sm:col-span-4 mt-2">
                                <x-jet-label for="nama_gudan" value="{{ __('Nama Gudang Hub') }}" />
                                <x-jet-input id="nama-kode-gudang" type="text" class="mt-1 block w-full"
                                    wire:model.defer="gudang.nama_gudang" />
                                <x-jet-input-error for="gudang.nama_gudang" class="mt-2" />
                            </div>

                        </x-slot>
                        
                        <x-slot name="footer">
                            <x-jet-secondary-button wire:click="$set('confirmationAdd', false)"
                                wire:loading.attr="disabled">
                                {{ __('Cancel') }}
                            </x-jet-secondary-button>

                            <x-jet-danger-button class="ml-3" wire:click="saveGudangHub()" wire:loading.attr="disabled">
                                {{ __('Save') }}
                            </x-jet-danger-button>
                        </x-slot>
                    </x-jet-dialog-modal>
                </div>
            </div>
        </div>
    </div>
</div>