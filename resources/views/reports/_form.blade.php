@if ($errors->any())
    <div class="mb-4 rounded bg-red-100 p-3 text-sm text-red-800">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-4">
    {{-- Area / Wilayah --}}
    <div>
        <label for="area_id" class="block text-sm font-medium text-gray-700">
            Area / Wilayah
        </label>
        <select id="area_id" name="area_id" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">-- Pilih area --</option>
            @foreach ($areas as $area)
                <option value="{{ $area->id }}"
                    @selected(old('area_id', $report->area_id ?? '') == $area->id)>
                    {{ $area->name }}
                </option>
            @endforeach
        </select>
        @error('area_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Judul --}}
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">
            Judul Laporan
        </label>
        <input id="title" name="title" type="text" maxlength="150" required
               value="{{ old('title', $report->title ?? '') }}"
               placeholder="Contoh: Asap tebal di kebun teh"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Deskripsi / Kondisi --}}
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">
            Kondisi / Deskripsi
        </label>
        <textarea id="description" name="description" rows="4" maxlength="2000" required
                  placeholder="Jelaskan kondisi yang dilihat, misalnya asap, api kecil, lahan terbakar, dan sebagainya."
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $report->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Koordinat --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label for="latitude" class="block text-sm font-medium text-gray-700">
                Latitude
            </label>
            <input id="latitude" name="latitude" type="number" step="any"
                   min="-90" max="90" required
                   value="{{ old('latitude', $report->latitude ?? '') }}"
                   placeholder="Contoh: -7.1500000"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('latitude')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="longitude" class="block text-sm font-medium text-gray-700">
                Longitude
            </label>
            <input id="longitude" name="longitude" type="number" step="any"
                   min="-180" max="180" required
                   value="{{ old('longitude', $report->longitude ?? '') }}"
                   placeholder="Contoh: 107.5000000"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('longitude')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Waktu kejadian --}}
    <div>
        <label for="occurred_at" class="block text-sm font-medium text-gray-700">
            Waktu Kejadian
        </label>
        <input id="occurred_at" name="occurred_at" type="datetime-local" required
               value="{{ old('occurred_at', isset($report) && $report->occurred_at ? $report->occurred_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        @error('occurred_at')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Bukti pendukung --}}
    <div>
        <label for="evidence" class="block text-sm font-medium text-gray-700">
            Bukti Pendukung <span class="font-normal text-gray-500">(opsional)</span>
        </label>
        <input id="evidence" name="evidence" type="file"
               accept=".jpg,.jpeg,.png,.pdf"
               class="mt-1 block w-full text-sm text-gray-700">
        <p class="mt-1 text-xs text-gray-500">
            Format yang diperbolehkan: JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
        </p>
        @error('evidence')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror

        @isset($report)
            @if ($report->evidence_path)
                <p class="mt-2 text-sm">
                    Bukti saat ini:
                    <a class="text-blue-600 underline" target="_blank"
                       href="{{ route('reports.evidence', $report) }}">
                        Lihat bukti
                    </a>.
                    Kosongkan input file jika tidak ingin mengganti bukti.
                </p>
            @endif
        @endisset
    </div>
</div>