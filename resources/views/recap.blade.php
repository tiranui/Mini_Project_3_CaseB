<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rekap Laporan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="GET" action="{{ route('recap') }}" class="bg-white shadow sm:rounded-lg p-4 flex gap-3 items-end">
                <div>
                    <label class="block text-sm">Area</label>
                    <select name="area_id" class="border-gray-300 rounded-md shadow-sm">
                        <option value="">Semua area</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" @selected(request('area_id') == $area->id)>{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
                <x-primary-button>Terapkan</x-primary-button>
            </form>

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white shadow sm:rounded-lg p-4"><p class="text-sm text-gray-500">Total laporan</p><p class="text-3xl font-bold">{{ $total }}</p></div>
                <div class="bg-white shadow sm:rounded-lg p-4"><p class="text-sm text-gray-500">Masih aktif</p><p class="text-3xl font-bold">{{ $aktif }}</p></div>
                <div class="bg-white shadow sm:rounded-lg p-4"><p class="text-sm text-gray-500">Selesai</p><p class="text-3xl font-bold">{{ $selesai }}</p></div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead><tr class="text-left border-b">
                        <th class="p-2">Area</th><th class="p-2">Total</th><th class="p-2">Aktif</th><th class="p-2">Selesai</th>
                    </tr></thead>
                    <tbody>
                    @foreach ($rows as $row)
                        <tr class="border-b">
                            <td class="p-2">{{ $row->name }}</td>
                            <td class="p-2">{{ $row->total_count }}</td>
                            <td class="p-2">{{ $row->active_count }}</td>
                            <td class="p-2">{{ $row->done_count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>