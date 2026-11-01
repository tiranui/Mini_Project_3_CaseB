<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Laporan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
            @endif

            @if (auth()->user()->isPelapor())
                <a href="{{ route('reports.create') }}" class="inline-block bg-gray-800 text-white px-4 py-2 rounded">+ Buat Laporan</a>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="p-2">Judul</th>
                            <th class="p-2">Area</th>
                            <th class="p-2">Status</th>
                            <th class="p-2">Waktu</th>
                            <th class="p-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($reports as $report)
                        <tr class="border-b">
                            <td class="p-2">{{ $report->title }}</td>
                            <td class="p-2">{{ $report->area->name }}</td>
                            <td class="p-2">{{ str_replace('_', ' ', $report->status) }}</td>
                            <td class="p-2">{{ $report->occurred_at->format('d M Y H:i') }}</td>
                            <td class="p-2">
                                <a class="text-blue-600" href="{{ route('reports.show', $report) }}">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="p-2">Belum ada laporan.</td></tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="mt-4">{{ $reports->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>