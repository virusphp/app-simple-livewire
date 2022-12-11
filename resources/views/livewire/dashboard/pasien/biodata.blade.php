<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Data Pasien') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="mt-8 text-2xl">
                    Data Pasien
                </div>
            
                <div class="mt-6 text-gray-500">
                   <table class="table-auto w-full">
                        <thead>
                           <tr>
                            <th class="px-4 py-2">Nama Pasien</th>
                            <th class="px-4 py-2">Alamat Pasien</th>
                            <th class="px-4 py-2">Tanggal Lahir</th>
                            <th class="px-4 py-2">Tempat Lahir</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Edit</th>
                           </tr>
                        </thead>
                        <tbody>
                            @foreach($pasien as $p)
                                <tr>
                                    <td class="border px-4 py-2">{{ $p->nama_pasien }}</td>
                                    <td class="border px-4 py-2">{{ $p->alamat_pasien }}</td>
                                    <td class="border px-4 py-2">{{ $p->tanggal_lahir }}</td>
                                    <td class="border px-4 py-2">{{ $p->tempat_lahir }}</td>
                                    <td class="border px-4 py-2">{{ $p->aktif }}</td>
                                    <td class="border px-4 py-2">EDIT</td>
                                </tr>
                            @endforeach
                        </tbody>
                   </table>
                </div>
                <div class="py-2 px-2">
                    {{ $pasien->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
