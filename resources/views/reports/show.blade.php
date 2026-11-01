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

@if (auth()->user()->isPelapor() && $report->user_id === auth()->id() && $report->isEditable())
    <a href="{{ route('reports.edit', $report) }}" class="inline-block bg-gray-800 text-white px-4 py-2 rounded">Edit Laporan</a>
@endif

@if (auth()->user()->isRelawan() && $report->status !== 'selesai')
    <form method="POST" action="{{ route('reports.review', $report) }}" class="bg-white shadow sm:rounded-lg p-6 space-y-3">
        @csrf
        @method('PATCH')
        <h3 class="font-semibold">Tinjau Laporan</h3>
        <select name="status" class="border-gray-300 rounded-md shadow-sm block w-full">
            <option value="sedang_ditinjau">sedang ditinjau</option>
            <option value="perlu_tindakan">perlu tindakan</option>
        </select>
        <textarea name="reviewer_note" rows="3" placeholder="Catatan peninjauan" class="border-gray-300 rounded-md shadow-sm block w-full">{{ old('reviewer_note', $report->reviewer_note) }}</textarea>
        <x-primary-button>Simpan Peninjauan</x-primary-button>
    </form>
@endif

@if (auth()->user()->isKoordinator() && $report->status !== 'selesai')
    <form method="POST" action="{{ route('reports.forward', $report) }}" class="bg-white shadow sm:rounded-lg p-6 space-y-3">
        @csrf
        @method('PATCH')
        <h3 class="font-semibold">Catat Penerusan Informasi</h3>
        <input type="text" name="forwarded_to" placeholder="Contoh: BPBD / Manggala Agni / Damkar"
               class="border-gray-300 rounded-md shadow-sm block w-full" value="{{ old('forwarded_to') }}">
        <x-primary-button>Catat Penerusan</x-primary-button>
    </form>
@endif
            {{-- Tahap 11: tabel riwayat status ditambahkan di sini --}}
        </div>
    </div>
</x-app-layout>