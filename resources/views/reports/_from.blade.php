@php $report = $report ?? null; @endphp

<div>
    <x-input-label for="area_id" value="Area / Wilayah" />
    <select id="area_id" name="area_id" class="border-gray-300 rounded-md shadow-sm mt-1 block w-full">
        <option value="">-- pilih area --</option>
        @foreach ($areas as $area)
            <option value="{{ $area->id }}" @selected(old('area_id', $report?->area_id) == $area->id)>{{ $area->name }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('area_id')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="title" value="Judul" />
    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $report?->title)" />
    <x-input-error :messages="$errors->get('title')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="description" value="Kondisi yang dilihat" />
    <textarea id="description" name="description" rows="4" class="border-gray-300 rounded-md shadow-sm mt-1 block w-full">{{ old('description', $report?->description) }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div class="mt-4 grid grid-cols-2 gap-4">
    <div>
        <x-input-label for="latitude" value="Latitude (-90 s/d 90)" />
        <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full" :value="old('latitude', $report?->latitude)" />
        <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="longitude" value="Longitude (-180 s/d 180)" />
        <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full" :value="old('longitude', $report?->longitude)" />
        <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
    </div>
</div>

<div class="mt-4">
    <x-input-label for="occurred_at" value="Waktu kejadian" />
    <input id="occurred_at" name="occurred_at" type="datetime-local"
           class="border-gray-300 rounded-md shadow-sm mt-1 block w-full"
           value="{{ old('occurred_at', $report?->occurred_at?->format('Y-m-d\TH:i')) }}">
    <x-input-error :messages="$errors->get('occurred_at')" class="mt-2" />
</div>