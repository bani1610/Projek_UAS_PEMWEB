<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Halo, {{ Auth::user()->name }}!</h3>

                    <!-- Bagian Mood Check-in -->
                    @if($moodToday)
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-6">
                            <p class="font-bold">Mood kamu hari ini: <span class="capitalize">{{ $moodToday->mood }}</span></p>
                            <p>Kamu sudah check-in untuk hari ini. Tetap semangat!</p>
                        </div>
                    @else
                        <div class="mb-6 p-6 border rounded-lg">
                            <h4 class="text-lg font-semibold mb-3">Bagaimana perasaanmu hari ini?</h4>
                            <form action="{{ route('moods.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-3 sm:grid-cols-7 gap-4 mb-4">
                                    @php
                                        $moods = ['senang' => '😄', 'semangat' => '😊', 'biasa' => '😐', 'ragu' => '🤔', 'lelah' => '😫', 'stres' => '😠', 'sedih' => '😥'];
                                    @endphp
                                    @foreach ($moods as $mood => $emoji)
                                        <label class="cursor-pointer text-center">
                                            <input type="radio" name="mood" value="{{ $mood }}" class="sr-only peer">
                                            <div class="p-4 border-2 rounded-lg peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-100">
                                                <span class="text-4xl">{{ $emoji }}</span>
                                                <p class="text-sm capitalize mt-1">{{ $mood }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('mood')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror

                                <div>
                                    <label for="catatan" class="block font-medium text-sm text-gray-700">Ada apa? (Opsional)</label>
                                    <textarea name="catatan" id="catatan" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                </div>

                                <div class="mt-4">
                                    <x-primary-button>Simpan Mood</x-primary-button>
                                </div>
                            </form>
                        </div>
                    @endif

                    <!-- Bagian Rekomendasi Tugas -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold mb-3">Rekomendasi Tugas Untukmu Hari Ini</h4>
                         @forelse ($recommendedTasks as $task)
                            <div class="bg-gray-50 p-4 rounded-lg mb-2 flex justify-between items-center">
                                <div>
                                    <p class="font-bold">{{ $task->judul_tugas }}</p>
                                    <p class="text-sm text-gray-600">Deadline: {{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</p>
                                </div>
                                <span class="text-xs font-semibold uppercase px-2 py-1 rounded-full
                                    @if($task->beban_kognitif == 'ringan') bg-green-200 text-green-800 @endif
                                    @if($task->beban_kognitif == 'sedang') bg-yellow-200 text-yellow-800 @endif
                                    @if($task->beban_kognitif == 'berat') bg-red-200 text-red-800 @endif
                                ">
                                    {{ $task->beban_kognitif }}
                                </span>
                            </div>
                        @empty
                            <p class="text-gray-500">Tidak ada tugas yang direkomendasikan saat ini. Mungkin waktunya istirahat atau menambah tugas baru?</p>
                        @endforelse
                    </div>

                    <a href="{{ route('tasks.index') }}" class="inline-block text-indigo-600 hover:text-indigo-900 font-semibold">
                        Lihat Semua Tugas &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
