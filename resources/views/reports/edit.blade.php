<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Laporan #{{ $report->id }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('reports.update', $report) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('reports._form')
                    <div class="mt-6">
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>