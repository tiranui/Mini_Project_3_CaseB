<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Laporan #{{ $report->id }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg p-6 space-y-2 text-sm">
                <p><b>Judul:</b> {{ $report->title }}</p>
                <p><b>Pelapor:</b> {{ $report->user->name }}</p>
                <p><b>Area:</b> {{ $report->area->name }}</p>
                <p><b>Koordinat:</b> {{ $report->latitude }}, {{ $report->longitude }}</p>
                <p><b>Waktu kejadian:</b> {{ $report->occurred_at->format('d M Y H:i') }}</p>
                <p><b>Kondisi:</b> {{ $report->description }}</p>
                <p><b>Status:</b> {{ str_replace('_', ' ', $report->status) }}</p>
                @if ($report->reviewer_note)
                    <p><b>Catatan relawan:</b> {{ $report->reviewer_note }}</p>
                @endif
                @if ($report->forwarded_to)
                    <p><b>Diteruskan ke:</b> {{ $report->forwarded_to }} ({{ $report->forwarded_at->format('d M Y H:i') }})</p>
                @endif
                @if ($report->evidence_path)
                    <p><a class="text-blue-600 underline" target="_blank" href="{{ route('reports.evidence', $report) }}">Lihat bukti</a></p>
                @endif
            </div>

            {{-- Tahap 8: tombol edit, form review & forward ditambahkan di sini --}}
            {{-- Tahap 11: tabel riwayat status ditambahkan di sini --}}
        </div>
    </div>
</x-app-layout>