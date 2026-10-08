<x-app-layout>

    <div class="py-12" x-data="{
        imgModal: false,
        imgModalSrc: '',
        deleteModal: false,
        deleteAction: '',
        deleteNama: ''
    }">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div
                x-data="{ show: false }"
                x-init="setTimeout(() => show = true, 100); setTimeout(() => show = false, 3100)"
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-10"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="fixed top-10 left-1/2 -translate-x-1/2 z-[100] flex items-center p-4 min-w-[320px] max-w-[90%] bg-white border border-emerald-100 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)]"
                style="display: none;"
            >
                <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full shadow-inner">
                    <i class="fas fa-check"></i>
                </div>

                <div class="ml-4 mr-8">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-500 leading-none mb-1">
                        Berhasil
                    </p>

                    <p class="text-sm font-semibold text-gray-700 leading-tight">
                        {{ session('success') }}
                    </p>
                </div>

                <button
                    @click="show = false"
                    class="absolute top-4 right-4 text-gray-300 hover:text-gray-500 transition-colors"
                >
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        @endif


        {{-- Error Message --}}
        @if(session('error'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 4000)"
                x-show="show"
                x-transition
                class="fixed top-10 left-1/2 -translate-x-1/2 z-[100] flex items-center p-4 min-w-[320px] max-w-[90%] bg-white border border-rose-100 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.15)]"
            >
                <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 bg-rose-100 text-rose-600 rounded-full shadow-inner">
                    <i class="fas fa-times"></i>
                </div>

                <div class="ml-4 mr-8">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-rose-500 leading-none mb-1">
                        Terekam Gagal
                    </p>

                    <p class="text-sm font-semibold text-gray-700 leading-tight">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        @endif


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header & Search --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                <div>
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">
                        Monitoring Goes To School
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Daftar kegiatan pelayanan perekaman KTP-el di sekolah.
                    </p>
                </div>


                <div class="flex flex-col md:flex-row items-center gap-3">

                    {{-- Form Pencarian --}}
                    <form
                        action="{{ route('goes_to_school.index') }}"
                        method="GET"
                        class="relative group w-full md:w-auto"
                    >
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari Nama Sekolah atau Tanggal..."
                            class="pl-10 pr-10 py-2.5 w-full md:w-72 bg-white border border-gray-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all"
                        >

                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500">
                            <i class="fas fa-search text-sm"></i>
                        </div>

                        @if(request('search'))
                            <a
                                href="{{ route('goes_to_school.index') }}"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-rose-500 transition-colors"
                            >
                                <i class="fas fa-times-circle"></i>
                            </a>
                        @endif
                    </form>


                    <a
                        href="{{ route('goes_to_school.create') }}"
                        class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg active:scale-95"
                    >
                        <i class="fas fa-plus-circle mr-2 text-lg"></i>
                        TAMBAH GOES TO SCHOOL
                    </a>

                </div>
            </div>


            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">

                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left border-collapse">

                        <thead class="text-[11px] text-gray-400 uppercase bg-gray-50/50 border-b border-gray-100">

                            <tr>

                                <th class="px-6 py-4 font-bold">
                                    Nama Sekolah
                                </th>

                                <th class="px-6 py-4 font-bold">
                                    Wilayah
                                </th>

                                <th class="px-6 py-4 font-bold">
                                    Hasil Kegiatan
                                </th>

                                {{-- RENCANA & PELAKSANAAN --}}
                                <th class="px-6 py-4 font-bold">
                                    Rencana & Pelaksanaan
                                </th>

                                {{-- DOKUMENTASI --}}
                                <th class="px-6 py-4 font-bold text-center">
                                    Dokumentasi
                                </th>

                                {{-- AKSI --}}
                                <th class="px-6 py-4 font-bold text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            @forelse($goesToSchools as $g)

                                <tr
                                    class="hover:bg-gray-50/50 transition-colors {{ $g->status_progress == 'proses' ? 'bg-amber-50/30' : '' }}"
                                    x-data="{ openUpdate: false }"
                                >

                                    {{-- NAMA SEKOLAH --}}
                                    <td class="px-6 py-4">

                                        <span class="block font-bold text-gray-800 uppercase leading-tight">
                                            {{ $g->nama_sekolah }}
                                        </span>

                                        <span class="block text-[10px] text-gray-400 mt-1">
                                            Target: {{ $g->jumlah_target }} siswa
                                        </span>

                                    </td>


                                    {{-- WILAYAH --}}
                                    <td class="px-6 py-4">

                                        <div class="text-xs font-semibold text-gray-700 uppercase">
                                            {{ $g->kelurahan }}
                                        </div>

                                        <div class="text-xs font-bold text-gray-500 uppercase mb-1">
                                            {{ str_replace('_', ' ', $g->kecamatan) }}
                                        </div>

                                    </td>


                                    {{-- HASIL KEGIATAN --}}
                                    <td class="px-6 py-4">

                                        <div class="grid grid-cols-2 gap-1 max-w-[220px]">

                                            <span class="text-[10px] bg-blue-50 text-blue-600 px-2 py-1 rounded font-semibold">
                                                Terekam: {{ $g->terekam ?? 0 }}
                                            </span>

                                            <span class="text-[10px] bg-red-50 text-red-600 px-2 py-1 rounded font-semibold">
                                                Terekam Gagal: {{ $g->terekam_gagal ?? 0 }}
                                            </span>

                                            <span class="text-[10px] bg-orange-50 text-orange-600 px-2 py-1 rounded font-semibold">
                                                &lt;16 Tahun: {{ $g->kurang_dari_16_tahun ?? 0 }}
                                            </span>

                                            <span class="text-[10px] bg-emerald-50 text-emerald-600 px-2 py-1 rounded font-semibold">
                                                Sudah Punya: {{ $g->sudah_punya ?? 0 }}
                                            </span>

                                            <span class="text-[10px] bg-gray-50 text-gray-600 px-2 py-1 rounded font-semibold">
                                                Tidak Hadir: {{ $g->tidak_hadir ?? 0 }}
                                            </span>

                                            <span class="text-[10px] bg-purple-50 text-purple-600 px-2 py-1 rounded font-semibold">
                                                Aktivasi IKD: {{ $g->aktivasi_ikd ?? 0 }}
                                            </span>

                                        </div>

                                    </td>


                                    {{-- RENCANA & PELAKSANAAN --}}
                                    <td class="px-6 py-4">

                                        {{-- RENCANA --}}
                                        <div class="flex items-center gap-2 mb-2">

                                            <div class="w-8 h-8 flex items-center justify-center bg-amber-50 text-amber-600 rounded-lg">
                                                <i class="fas fa-calendar-check text-xs"></i>
                                            </div>

                                            <div>

                                                @if($g->jadwal_pelaksanaan)

                                                    <span class="block text-xs font-semibold text-gray-600">
                                                        {{ $g->jadwal_pelaksanaan }}
                                                    </span>

                                                    <span class="block text-[10px] text-gray-400">
                                                        Rencana
                                                    </span>

                                                @else

                                                    <span class="block text-xs text-gray-400">
                                                        Belum ada rencana
                                                    </span>

                                                @endif

                                            </div>

                                        </div>


                                        {{-- TANGGAL PELAKSANAAN --}}
                                        @if($g->tanggal_pelaksanaan)

                                            <div class="flex items-center gap-2">

                                                <div class="w-8 h-8 flex items-center justify-center bg-indigo-50 text-indigo-600 rounded-lg">
                                                    <i class="fas fa-calendar-alt text-xs"></i>
                                                </div>

                                                <div>

                                                    <span class="block text-xs font-bold text-gray-700">
                                                        {{ \Carbon\Carbon::parse($g->tanggal_pelaksanaan)->format('d/m/Y') }}
                                                    </span>

                                                    <span class="block text-[10px] text-indigo-500">
                                                        Tanggal Pelaksanaan
                                                    </span>

                                                </div>

                                            </div>

                                        @else

                                            <div class="flex items-center gap-2">

                                                <div class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-400 rounded-lg">
                                                    <i class="fas fa-calendar-alt text-xs"></i>
                                                </div>

                                                <span class="text-xs text-gray-400">
                                                    Belum ada tanggal pelaksanaan
                                                </span>

                                            </div>

                                        @endif

                                    </td>


                                    {{-- DOKUMENTASI --}}
                                    <td class="px-6 py-4 text-center">

                                        <div class="flex justify-center -space-x-2">

                                            @if($g->foto_1)

                                                <img
                                                    @click="imgModal = true; imgModalSrc = '{{ asset('storage/' . $g->foto_1) }}'"
                                                    src="{{ asset('storage/' . $g->foto_1) }}"
                                                    class="h-9 w-9 rounded-full ring-2 ring-white object-cover cursor-zoom-in hover:scale-110 shadow-sm transition-transform"
                                                >

                                            @endif


                                            @if($g->foto_2)

                                                <img
                                                    @click="imgModal = true; imgModalSrc = '{{ asset('storage/' . $g->foto_2) }}'"
                                                    src="{{ asset('storage/' . $g->foto_2) }}"
                                                    class="h-9 w-9 rounded-full ring-2 ring-white object-cover cursor-zoom-in hover:scale-110 shadow-sm transition-transform"
                                                >

                                            @endif


                                            @if(!$g->foto_1 && !$g->foto_2)

                                                <div class="h-9 w-9 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                                    <i class="fas fa-image text-gray-300 text-[10px]"></i>
                                                </div>

                                            @endif

                                        </div>

                                    </td>


                                    {{-- AKSI --}}
                                    <td class="px-6 py-4">

                                        <div class="flex items-center justify-center gap-2">

                                            {{-- EDIT --}}
                                            @if($g->status_progress !== 'selesai')

                                                <a
                                                    href="{{ route('goes_to_school.edit', $g->id) }}"
                                                    title="Edit Data Goes To School"
                                                    class="w-8 h-8 flex items-center justify-center bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-500 hover:text-white transition-all shadow-sm"
                                                >
                                                    <i class="fas fa-edit text-xs"></i>
                                                </a>

                                            @endif


                                            {{-- SELESAI --}}
                                            @if($g->status_progress == 'proses')

                                                <button
                                                    @click.prevent="openUpdate = true"
                                                    title="Selesaikan Kegiatan"
                                                    class="w-8 h-8 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-all shadow-sm"
                                                >
                                                    <i class="fas fa-check text-xs"></i>
                                                </button>

                                            @endif


                                            {{-- DOWNLOAD --}}
                                            @if($g->status_progress == 'selesai')

                                                <a
                                                    href="{{ route('goes_to_school.download', $g->id) }}"
                                                    title="Unduh Laporan"
                                                    class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all shadow-sm"
                                                >
                                                    <i class="fas fa-file-download text-xs"></i>
                                                </a>

                                            @endif


                                            {{-- DELETE --}}
                                            <button
                                                type="button"
                                                @click="deleteModal = true; deleteAction = '{{ route('goes_to_school.destroy', $g->id) }}'; deleteNama = '{{ $g->nama_sekolah }}'"
                                                title="Hapus Data"
                                                class="w-8 h-8 flex items-center justify-center bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-500 hover:text-white transition-all shadow-sm"
                                            >
                                                <i class="fas fa-trash-alt text-xs"></i>
                                            </button>

                                        </div>


                                        {{-- Modal Update Progress --}}
                                        <template x-if="openUpdate">

                                            <div class="fixed inset-0 z-[60] overflow-y-auto text-left">

                                                <div
                                                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
                                                    @click="openUpdate = false"
                                                ></div>


                                                <div class="flex items-center justify-center min-h-screen p-4">

                                                    <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden">

                                                        {{-- Header Modal --}}
                                                        <div class="bg-emerald-600 px-6 py-4 flex justify-between items-center text-white">

                                                            <h3 class="text-lg font-bold">
                                                                Penyelesaian Goes To School
                                                            </h3>

                                                            <button
                                                                @click="openUpdate = false"
                                                                class="text-white text-2xl leading-none"
                                                            >
                                                                &times;
                                                            </button>

                                                        </div>


                                                        <form
                                                            action="{{ route('goes_to_school.update', $g->id) }}"
                                                            method="POST"
                                                            enctype="multipart/form-data"
                                                            class="p-6 space-y-4"
                                                        >

                                                            @csrf
                                                            @method('PUT')


                                                            {{-- Nama Sekolah --}}
                                                            <div class="text-center border-b pb-4">

                                                                <h6 class="font-bold text-gray-800 uppercase">
                                                                    {{ $g->nama_sekolah }}
                                                                </h6>

                                                                <p class="text-xs text-gray-400">
                                                                    Target: {{ $g->jumlah_target }} siswa
                                                                </p>

                                                            </div>


                                                            {{-- Tanggal & Rencana --}}
                                                            <div class="grid grid-cols-2 gap-4">

                                                                {{-- Tanggal Pelaksanaan --}}
                                                                <div>

                                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">
                                                                        Tanggal Pelaksanaan
                                                                    </label>

                                                                    <input
                                                                        type="date"
                                                                        name="tanggal_pelaksanaan"
                                                                        value="{{ $g->tanggal_pelaksanaan }}"
                                                                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-emerald-500"
                                                                        required
                                                                    >

                                                                </div>


                                                                {{-- Rencana Pelaksanaan --}}
                                                                <div>

                                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">
                                                                        Rencana Pelaksanaan
                                                                    </label>

                                                                    <input
                                                                        type="text"
                                                                        name="jadwal_pelaksanaan"
                                                                        value="{{ $g->jadwal_pelaksanaan }}"
                                                                        placeholder="Contoh: 08.00 - 12.00"
                                                                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-emerald-500"
                                                                    >

                                                                </div>

                                                            </div>


                                                            {{-- Wilayah --}}
                                                            <div class="grid grid-cols-2 gap-4">

                                                                <div>

                                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">
                                                                        Kecamatan
                                                                    </label>

                                                                    <input
                                                                        type="text"
                                                                        name="kecamatan"
                                                                        value="{{ $g->kecamatan }}"
                                                                        class="w-full border-gray-300 rounded-lg text-sm"
                                                                        required
                                                                    >

                                                                </div>


                                                                <div>

                                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">
                                                                        Kelurahan
                                                                    </label>

                                                                    <input
                                                                        type="text"
                                                                        name="kelurahan"
                                                                        value="{{ $g->kelurahan }}"
                                                                        class="w-full border-gray-300 rounded-lg text-sm"
                                                                        required
                                                                    >

                                                                </div>

                                                            </div>


                                                            {{-- Hasil Kegiatan --}}
                                                            <div>

                                                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-3">
                                                                    Hasil Kegiatan
                                                                </label>

                                                                <div class="grid grid-cols-2 gap-3">

                                                                    {{-- TEREKAM --}}
                                                                    <div>

                                                                        <label class="block text-[10px] font-semibold text-blue-600 mb-1">
                                                                            Terekam
                                                                        </label>

                                                                        <input
                                                                            type="number"
                                                                            name="terekam"
                                                                            value="{{ $g->terekam ?? 0 }}"
                                                                            min="0"
                                                                            class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500"
                                                                        >

                                                                    </div>


                                                                    {{-- TEREKAM GAGAL --}}
                                                                    <div>

                                                                        <label class="block text-[10px] font-semibold text-red-600 mb-1">
                                                                            Terekam Gagal
                                                                        </label>

                                                                        <input
                                                                            type="number"
                                                                            name="terekam_gagal"
                                                                            value="{{ $g->terekam_gagal ?? 0 }}"
                                                                            min="0"
                                                                            class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500"
                                                                        >

                                                                    </div>


                                                                    {{-- KURANG DARI 16 TAHUN --}}
                                                                    <div>

                                                                        <label class="block text-[10px] font-semibold text-orange-600 mb-1">
                                                                            &lt;16 Tahun
                                                                        </label>

                                                                        <input
                                                                            type="number"
                                                                            name="kurang_dari_16_tahun"
                                                                            value="{{ $g->kurang_dari_16_tahun ?? 0 }}"
                                                                            min="0"
                                                                            class="w-full border-gray-300 rounded-lg text-sm focus:ring-orange-500 focus:border-orange-500"
                                                                        >

                                                                    </div>


                                                                    {{-- SUDAH PUNYA KTP --}}
                                                                    <div>

                                                                        <label class="block text-[10px] font-semibold text-emerald-600 mb-1">
                                                                            Sudah Punya KTP
                                                                        </label>

                                                                        <input
                                                                            type="number"
                                                                            name="sudah_punya"
                                                                            value="{{ $g->sudah_punya ?? 0 }}"
                                                                            min="0"
                                                                            class="w-full border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500"
                                                                        >

                                                                    </div>


                                                                    {{-- TIDAK HADIR --}}
                                                                    <div>

                                                                        <label class="block text-[10px] font-semibold text-gray-600 mb-1">
                                                                            Tidak Hadir
                                                                        </label>

                                                                        <input
                                                                            type="number"
                                                                            name="tidak_hadir"
                                                                            value="{{ $g->tidak_hadir ?? 0 }}"
                                                                            min="0"
                                                                            class="w-full border-gray-300 rounded-lg text-sm focus:ring-gray-500 focus:border-gray-500"
                                                                        >

                                                                    </div>


                                                                    {{-- AKTIVASI IKD --}}
                                                                    <div>

                                                                        <label class="block text-[10px] font-semibold text-purple-600 mb-1">
                                                                            Aktivasi IKD
                                                                        </label>

                                                                        <input
                                                                            type="number"
                                                                            name="aktivasi_ikd"
                                                                            value="{{ $g->aktivasi_ikd ?? 0 }}"
                                                                            min="0"
                                                                            class="w-full border-purple-300 rounded-lg text-sm focus:ring-purple-500 focus:border-purple-500"
                                                                        >

                                                                    </div>

                                                                </div>

                                                            </div>


                                                            {{-- Dokumentasi --}}
                                                            <div class="p-4 bg-gray-50 rounded-xl border-2 border-dashed text-center space-y-3">

                                                                <p class="text-[10px] font-bold text-gray-400 uppercase">
                                                                    Dokumentasi
                                                                </p>


                                                                <input
                                                                    type="file"
                                                                    name="foto_1"
                                                                    class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-emerald-50 file:text-emerald-700"
                                                                    accept="image/*"
                                                                >


                                                                <input
                                                                    type="file"
                                                                    name="foto_2"
                                                                    class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-emerald-50 file:text-emerald-700"
                                                                    accept="image/*"
                                                                >

                                                            </div>


                                                            {{-- Tombol --}}
                                                            <div class="flex justify-end items-center gap-4 pt-4 border-t">

                                                                <button
                                                                    type="button"
                                                                    @click="openUpdate = false"
                                                                    class="text-xs font-bold text-gray-400 hover:text-gray-600"
                                                                >
                                                                    BATAL
                                                                </button>


                                                                <button
                                                                    type="submit"
                                                                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md active:scale-95 transition-all"
                                                                >
                                                                    SIMPAN PERUBAHAN
                                                                </button>

                                                            </div>

                                                        </form>

                                                    </div>

                                                </div>

                                            </div>

                                        </template>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="6" class="px-6 py-20 text-center">

                                        <div class="flex flex-col items-center">

                                            <i class="fas fa-school text-gray-200 text-5xl mb-4"></i>

                                            <p class="text-gray-400 font-medium">

                                                {{
                                                    request('search')
                                                        ? 'Pencarian "' . request('search') . '" tidak ditemukan.'
                                                        : 'Belum ada data Goes To School yang terdaftar.'
                                                }}

                                            </p>


                                            @if(request('search'))

                                                <a
                                                    href="{{ route('goes_to_school.index') }}"
                                                    class="mt-2 text-indigo-500 text-sm font-bold hover:underline"
                                                >
                                                    Lihat semua data
                                                </a>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- Image Preview Modal --}}
        <div
            x-show="imgModal"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/95"
            x-transition
            @click="imgModal = false"
            style="display: none;"
        >

            <button class="absolute top-5 right-5 text-white text-4xl font-light">
                &times;
            </button>

            <img
                :src="imgModalSrc"
                class="max-h-full max-w-full rounded shadow-2xl border border-white/10"
            >

        </div>


        {{-- Delete Confirmation Modal --}}
        <template x-if="deleteModal">

            <div class="fixed inset-0 z-[110] overflow-y-auto">

                <div
                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
                    @click="deleteModal = false"
                ></div>


                <div class="flex items-center justify-center min-h-screen p-4">

                    <div
                        class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 text-center"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                    >

                        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-rose-50 mb-6">
                            <i class="fas fa-trash-alt text-3xl text-rose-500"></i>
                        </div>


                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            Hapus Data?
                        </h3>


                        <p class="text-sm text-gray-500">
                            Menghapus data sekolah:
                        </p>


                        <p
                            class="text-sm font-bold text-gray-700 mb-8 uppercase"
                            x-text="deleteNama"
                        ></p>


                        <div class="flex flex-col gap-3">

                            <form :action="deleteAction" method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full py-3 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl shadow-lg shadow-rose-100 active:scale-95 transition-all"
                                >
                                    YA, HAPUS PERMANEN
                                </button>

                            </form>


                            <button
                                @click="deleteModal = false"
                                class="w-full py-3 bg-gray-50 text-gray-500 font-bold rounded-xl"
                            >
                                BATALKAN
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </template>

    </div>

</x-app-layout>