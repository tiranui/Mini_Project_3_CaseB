<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Laporan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded">Filter tidak valid.</div>
            @endif

            @if (auth()->user()->isPelapor())
                <a href="{{ route('reports.create') }}" class="inline-block bg-gray-800 text-white px-4 py-2 rounded">+ Buat Laporan</a>
            @endif

            <form method="GET" action="{{ route('reports.index') }}" class="bg-white shadow sm:rounded-lg p-4 flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-sm">Cari judul</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label class="block text-sm">Area</label>
                    <select name="area_id" class="border-gray-300 rounded-md shadow-sm">
                        <option value="">Semua</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" @selected(request('area_id') == $area->id)>{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm">Status</label>
                    <select name="status" class="border-gray-300 rounded-md shadow-sm">
                        <option value="">Semua</option>
                        @foreach (\App\Models\Report::STATUSES as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ str_replace('_', ' ', $status) }}</option>
                        @endforeach
                    </select>
                </div>
                <x-primary-button>Terapkan</x-primary-button>
                <a href="{{ route('reports.index') }}" class="text-sm text-gray-600 underline">Reset</a>
            </form>

            <div class="bg-white shadow sm:rounded-lg p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead><tr class="text-left border-b">
                        <th class="p-2">Judul</th>
                        <th class="p-2">Area</th>
                        @unless (auth()->user()->isPelapor())<th class="p-2">Pelapor</th>@endunless
                        <th class="p-2">Status</th>
                        <th class="p-2">Waktu</th>
                        <th class="p-2"></th>
                    </tr></thead>
                    <tbody>
                    @forelse ($reports as $report)
                        <tr class="border-b">
                            <td class="p-2">{{ $report->title }}</td>
                            <td class="p-2">{{ $report->area->name }}</td>
                            @unless (auth()->user()->isPelapor())<td class="p-2">{{ $report->user->name }}</td>@endunless
                            <td class="p-2">{{ str_replace('_', ' ', $report->status) }}</td>
                            <td class="p-2">{{ $report->occurred_at->format('d M Y H:i') }}</td>
                            <td class="p-2"><a class="text-blue-600 underline" href="{{ route('reports.show', $report) }}">Detail</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-2">Tidak ada laporan.</td></tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $reports->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>