<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Laporan Guru per Kelas
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto mt-10">
        <div class="p-6 bg-white rounded-lg shadow-md">

            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Kelas</th>
                        <th class="px-4 py-2 border">Daftar Guru</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Looping data kelas, lalu tampilkan nama kelas dan daftar guru --}}
                    @foreach ($data as $kelas)
                        <tr>
                            <td class="px-4 py-2 font-semibold border">
                                {{ $kelas->nama_kelas }}
                            </td>
                            <td class="px-4 py-2 border">
                                @forelse($kelas->gurus as $guru)
                                    • {{ $guru->nama }} <br>
                                @empty
                                    Tidak ada guru
                                @endforelse
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>
