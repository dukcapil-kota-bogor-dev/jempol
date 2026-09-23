<x-app-layout>

    <div class="py-12"
        x-data="{
            imgModal: false,
            imgModalSrc: '',
            deleteModal: false,
            deleteAction: '',
            deleteNama: ''
        }">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3100)"
                x-show="show"
                x-transition
                class="fixed top-10 left-1/2 -translate-x-1/2 z-[100] flex items-center p-4 min-w-[320px] max-w-[90%] bg-white border border-emerald-100 rounded-2xl shadow-xl">

                <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full">
                    <i class="fas fa-check"></i>
                </div>

                <div class="ml-4 mr-8">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-500 mb-1">
                        Berhasil
                    </p>

                    <p class="text-sm font-semibold text-gray-700">
                        {{ session('success') }}
                    </p>
                </div>

                <button
                    @click="show = false"
                    class="absolute top-4 right-4 text-gray-300 hover:text-gray-500">

                    <i class="fas fa-times text-xs"></i>

                </button>

            </div>
        @endif


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- HEADER --}}
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

                    {{-- PENCARIAN --}}
                    <form
                        action="{{ route('goes_to_school.index') }}"
                        method="GET"
                        class="relative group w-full md:w-auto">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari Nama Sekolah atau Tanggal..."
                            class="pl-10 pr-10 py-2.5 w-full md:w-72 bg-white border border-gray-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all">

                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search text-sm"></i>
                        </div>

                        @if(request('search'))
                            <a
                                href="{{ route('goes_to_school.index') }}"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-rose-500">

                                <i class="fas fa-times-circle"></i>

                            </a>
                        @endif

                    </form>


                    {{-- TAMBAH --}}
                    <a
                        href="{{ route('goes_to_school.create') }}"
                        class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg">

                        <i class="fas fa-plus-circle mr-2 text-lg"></i>

                        TAMBAH GOES TO SCHOOL

                    </a>

                </div>

            </div>


            {{-- TABLE --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">

                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left border-collapse">

                        <thead class="text-[11px] text-gray-400 uppercase bg-gray-50/50 border-b border-gray-100">

                            <tr>

                                <th class="px-6 py-4 font-bold text-center">
                                    Nama Sekolah
                                </th>

                                <th class="px-6 py-4 font-bold">
                                    Wilayah
                                </th>

                                <th class="px-6 py-4 font-bold text-center">
                                    Hasil Perekaman
                                </th>

                                <th class="px-6 py-4 font-bold text-center">
                                    Status IKD
                                </th>

                                <th class="px-6 py-4 font-bold text-center">
                                    Pelaksanaan
                                </th>

                                <th class="px-6 py-4 font-bold text-center">
                                    Dokumentasi
                                </th>

                                <th class="px-6 py-4 font-bold text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                            @forelse($goesToSchools as $g)

                                <tr
                                    x-data="{
                                        openUpdate: false,
                                        showLuarWilayah: false
                                    }"
                                    class="hover:bg-gray-50/50 transition-colors
                                    {{ $g->status_progress == 'proses' ? 'bg-amber-50/30' : '' }}">

                                    {{-- NAMA SEKOLAH --}}
                                    <td class="px-6 py-5">

                                        <div class="font-bold text-gray-800 uppercase">
                                            {{ $g->nama_sekolah }}
                                        </div>

                                        <div class="text-[10px] text-gray-400 mt-1">

                                            Target:

                                            <span class="font-bold text-gray-600">
                                                {{ $g->jumlah_target }}
                                            </span>

                                            siswa

                                        </div>

                                    </td>


                                    {{-- WILAYAH --}}
                                    <td class="px-6 py-5">

                                        <div class="text-xs font-bold text-gray-700 uppercase">
                                            {{ $g->kelurahan ?: '-' }}
                                        </div>

                                        <div class="text-[10px] text-gray-500 uppercase mt-1">
                                            {{ $g->kecamatan ? str_replace('_', ' ', $g->kecamatan) : '-' }}
                                        </div>

                                    </td>


                                    {{-- HASIL PEREKAMAN --}}
                                    <td class="px-6 py-5">

                                        <div class="grid grid-cols-2 gap-1 min-w-[190px]">

                                            <span class="text-[10px] px-2 py-1 rounded bg-blue-50 text-blue-700">

                                                Terekam:

                                                <b>
                                                    {{ $g->terekam ?? 0 }}
                                                </b>

                                            </span>


                                            <span class="text-[10px] px-2 py-1 rounded bg-red-50 text-red-700">

                                                Gagal:

                                                <b>
                                                    {{ $g->terekam_gagal ?? 0 }}
                                                </b>

                                            </span>


                                            <span class="text-[10px] px-2 py-1 rounded bg-orange-50 text-orange-700">

                                                &lt;16 Tahun:

                                                <b>
                                                    {{ $g->kurang_dari_16_tahun ?? 0 }}
                                                </b>

                                            </span>


                                            <span class="text-[10px] px-2 py-1 rounded bg-green-50 text-green-700">

                                                Sudah Punya:

                                                <b>
                                                    {{ $g->sudah_punya ?? 0 }}
                                                </b>

                                            </span>


                                            <span class="text-[10px] px-2 py-1 rounded bg-gray-50 text-gray-600 col-span-2">

                                                Tidak Hadir:

                                                <b>
                                                    {{ $g->tidak_hadir ?? 0 }}
                                                </b>

                                            </span>

                                        </div>

                                    </td>


                                    {{-- STATUS IKD --}}
                                    <td class="px-6 py-5 text-center">

                                        @if($g->status_ikd === 'sudah_aktivasi')

                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-600 border border-purple-100">

                                                <i class="fas fa-check-circle mr-1"></i>

                                                Sudah Aktivasi

                                            </span>

                                        @else

                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500 border border-gray-200">

                                                <i class="fas fa-minus-circle mr-1"></i>

                                                Belum Aktivasi

                                            </span>

                                        @endif

                                    </td>


                                    {{-- PELAKSANAAN --}}
                                    <td class="px-6 py-5 text-center">

                                        @if($g->tanggal_pelaksanaan)

                                            <div class="text-xs font-bold text-gray-700">

                                                {{ \Carbon\Carbon::parse($g->tanggal_pelaksanaan)->format('d/m/Y') }}

                                            </div>

                                        @else

                                            <div class="text-[10px] text-gray-300 italic">
                                                Belum ada tanggal
                                            </div>

                                        @endif


                                        <div class="text-[10px] text-gray-400 mt-1">

                                            {{ $g->jadwal_pelaksanaan ?: '-' }}

                                        </div>


                                        {{-- STATUS SELESAI --}}
                                        @if($g->status_progress === 'selesai')

                                            <span class="inline-flex items-center mt-1 text-[10px] font-bold text-emerald-600">

                                                <i class="fas fa-check-circle mr-1"></i>

                                                Selesai

                                            </span>

                                        @else

                                            <span class="inline-flex items-center mt-1 text-[10px] font-bold text-amber-600">

                                                <i class="fas fa-spinner fa-spin mr-1"></i>

                                                Pending

                                            </span>

                                        @endif

                                    </td>


                                    {{-- DOKUMENTASI --}}
                                    <td class="px-6 py-5 text-center">

                                        <div class="flex justify-center -space-x-2">

                                            @if($g->foto_1)

                                                <img
                                                    @click="imgModal = true; imgModalSrc = '{{ asset('storage/' . $g->foto_1) }}'"
                                                    src="{{ asset('storage/' . $g->foto_1) }}"
                                                    class="h-10 w-10 rounded-full ring-2 ring-white object-cover cursor-zoom-in hover:scale-110 shadow-sm">

                                            @endif


                                            @if($g->foto_2)

                                                <img
                                                    @click="imgModal = true; imgModalSrc = '{{ asset('storage/' . $g->foto_2) }}'"
                                                    src="{{ asset('storage/' . $g->foto_2) }}"
                                                    class="h-10 w-10 rounded-full ring-2 ring-white object-cover cursor-zoom-in hover:scale-110 shadow-sm">

                                            @endif


                                            @if(!$g->foto_1 && !$g->foto_2)

                                                <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">

                                                    <i class="fas fa-image text-gray-300 text-xs"></i>

                                                </div>

                                            @endif

                                        </div>

                                    </td>


                                    {{-- AKSI --}}
                                    <td class="px-6 py-5 text-center">

                                        <div class="flex items-center justify-center gap-2">

                                            {{-- EDIT --}}
                                            @if($g->status_progress !== 'selesai')

                                                <a
                                                    href="{{ route('goes_to_school.edit', $g->id) }}"
                                                    title="Edit Data"
                                                    class="w-8 h-8 flex items-center justify-center bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-500 hover:text-white transition-all shadow-sm">

                                                    <i class="fas fa-edit text-xs"></i>

                                                </a>

                                            @endif


                                            {{-- TOMBOL SELESAI --}}
                                            @if($g->status_progress === 'proses')

                                                <button
                                                    type="button"
                                                    @click="openUpdate = true"
                                                    title="Selesaikan Kegiatan"
                                                    class="w-8 h-8 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-all shadow-sm">

                                                    <i class="fas fa-check text-xs"></i>

                                                </button>

                                            @endif


                                            {{-- DOWNLOAD --}}
                                            @if($g->status_progress === 'selesai')

                                                <a
                                                    href="{{ route('goes_to_school.download', $g->id) }}"
                                                    title="Unduh Laporan"
                                                    class="w-8 h-8 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all shadow-sm">

                                                    <i class="fas fa-file-download text-xs"></i>

                                                </a>

                                            @endif


                                            {{-- HAPUS --}}
                                            <button
                                                type="button"
                                                @click="
                                                    deleteModal = true;
                                                    deleteAction = '{{ route('goes_to_school.destroy', $g->id) }}';
                                                    deleteNama = '{{ $g->nama_sekolah }}';
                                                "
                                                title="Hapus Data"
                                                class="w-8 h-8 flex items-center justify-center bg-rose-50 text-rose-500 rounded-lg hover:bg-rose-500 hover:text-white transition-all shadow-sm">

                                                <i class="fas fa-trash-alt text-xs"></i>

                                            </button>

                                        </div>


                                        {{-- MODAL SELESAIKAN KEGIATAN --}}
                                        <template x-if="openUpdate">

                                            <div class="fixed inset-0 z-[90] overflow-y-auto text-left">

                                                {{-- BACKDROP --}}
                                                <div
                                                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
                                                    @click="openUpdate = false">
                                                </div>


                                                <div class="flex items-center justify-center min-h-screen p-4">

                                                    <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden">

                                                        {{-- HEADER MODAL --}}
                                                        <div class="bg-emerald-600 px-6 py-4 flex justify-between items-center text-white">

                                                            <div>

                                                                <h3 class="text-lg font-bold">
                                                                    Penyelesaian Goes To School
                                                                </h3>

                                                                <p class="text-xs text-emerald-100 mt-1">
                                                                    Lengkapi data kegiatan sebelum diselesaikan.
                                                                </p>

                                                            </div>


                                                            <button
                                                                type="button"
                                                                @click="openUpdate = false"
                                                                class="text-white text-2xl leading-none">

                                                                &times;

                                                            </button>

                                                        </div>


                                                        {{-- FORM --}}
                                                        <form
                                                            action="{{ route('goes_to_school.update', $g->id) }}"
                                                            method="POST"
                                                            enctype="multipart/form-data"
                                                            class="p-6 space-y-4">

                                                            @csrf
                                                            @method('PUT')


                                                            {{-- IDENTITAS --}}
                                                            <div class="text-center border-b pb-4">

                                                                <h6 class="font-bold text-gray-800 uppercase">
                                                                    {{ $g->nama_sekolah }}
                                                                </h6>

                                                                <p class="text-xs text-gray-400 mt-1">
                                                                    Target {{ $g->jumlah_target }} siswa
                                                                </p>

                                                            </div>


                                                            {{-- TANGGAL & LOKASI --}}
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                                                {{-- TANGGAL --}}
                                                                <div>

                                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">
                                                                        Tanggal Pelaksanaan
                                                                    </label>

                                                                    <input
                                                                        type="date"
                                                                        name="tanggal_pelaksanaan"
                                                                        value="{{ $g->tanggal_pelaksanaan }}"
                                                                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500"
                                                                        required>

                                                                </div>


                                                                {{-- LOKASI --}}
                                                                <div>

                                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">
                                                                        Lokasi
                                                                    </label>

                                                                    <input
                                                                        type="text"
                                                                        name="lokasi_perekaman"
                                                                        value="{{ $g->lokasi_perekaman ?? $g->kelurahan }}"
                                                                        placeholder="Lokasi kegiatan"
                                                                        class="w-full border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500"
                                                                        required>

                                                                </div>

                                                            </div>


                                                            {{-- DOKUMENTASI --}}
                                                            <div class="p-4 bg-gray-50 rounded-xl border-2 border-dashed text-center space-y-3">

                                                                <p class="text-[10px] font-bold text-gray-400 uppercase">
                                                                    Dokumentasi Kegiatan
                                                                </p>


                                                                {{-- FOTO 1 --}}
                                                                <div class="text-left">

                                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">
                                                                        Foto 1
                                                                    </label>

                                                                    <input
                                                                        type="file"
                                                                        name="foto_1"
                                                                        class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-emerald-50 file:text-emerald-700"
                                                                        accept="image/*"
                                                                        {{ $g->foto_1 ? '' : 'required' }}>

                                                                    @if($g->foto_1)

                                                                        <p class="text-[9px] text-gray-400 mt-1">
                                                                            Foto sebelumnya sudah tersedia. Upload hanya jika ingin mengganti.
                                                                        </p>

                                                                    @endif

                                                                </div>


                                                                {{-- FOTO 2 --}}
                                                                <div class="text-left">

                                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">
                                                                        Foto 2
                                                                    </label>

                                                                    <input
                                                                        type="file"
                                                                        name="foto_2"
                                                                        class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-emerald-50 file:text-emerald-700"
                                                                        accept="image/*"
                                                                        {{ $g->foto_2 ? '' : 'required' }}>

                                                                    @if($g->foto_2)

                                                                        <p class="text-[9px] text-gray-400 mt-1">
                                                                            Foto sebelumnya sudah tersedia. Upload hanya jika ingin mengganti.
                                                                        </p>

                                                                    @endif

                                                                </div>

                                                            </div>


                                                            {{-- KETERANGAN --}}
                                                            <div>

                                                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">
                                                                    Keterangan
                                                                </label>

                                                                <textarea
                                                                    name="keterangan"
                                                                    rows="3"
                                                                    class="w-full border-gray-300 rounded-lg text-sm focus:ring-emerald-500 focus:border-emerald-500"
                                                                    placeholder="Catatan hasil kegiatan...">{{ $g->keterangan ?? '' }}</textarea>

                                                            </div>


                                                            {{-- TOMBOL --}}
                                                            <div class="flex justify-end items-center gap-4 pt-4 border-t">

                                                                <button
                                                                    type="button"
                                                                    @click="openUpdate = false"
                                                                    class="text-xs font-bold text-gray-400 hover:text-gray-600">

                                                                    BATAL

                                                                </button>


                                                                <button
                                                                    type="submit"
                                                                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md active:scale-95 transition-all">

                                                                    <i class="fas fa-check mr-2"></i>

                                                                    SIMPAN & SELESAIKAN

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

                                    <td colspan="7" class="px-6 py-20 text-center">

                                        <div class="flex flex-col items-center">

                                            <i class="fas fa-school text-gray-200 text-5xl mb-4"></i>

                                            <p class="text-gray-400 font-medium">

                                                {{ request('search')
                                                    ? 'Pencarian "' . request('search') . '" tidak ditemukan.'
                                                    : 'Belum ada data Goes To School yang terdaftar.'
                                                }}

                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- IMAGE MODAL --}}
        <div
            x-show="imgModal"
            x-transition
            @click="imgModal = false"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/95"
            style="display: none;">

            <button
                type="button"
                class="absolute top-5 right-5 text-white text-4xl font-light">

                &times;

            </button>


            <img
                :src="imgModalSrc"
                class="max-h-full max-w-full rounded shadow-2xl">

        </div>


        {{-- DELETE MODAL --}}
        <template x-if="deleteModal">

            <div class="fixed inset-0 z-[110] overflow-y-auto">

                <div
                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"
                    @click="deleteModal = false">
                </div>


                <div class="flex items-center justify-center min-h-screen p-4">

                    <div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full p-8 text-center">

                        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-rose-50 mb-6">

                            <i class="fas fa-trash-alt text-3xl text-rose-500"></i>

                        </div>


                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            Hapus Data?
                        </h3>


                        <p class="text-sm text-gray-500">
                            Menghapus data Goes To School:
                        </p>


                        <p
                            class="text-sm font-bold text-gray-700 mb-8 uppercase"
                            x-text="deleteNama">
                        </p>


                        <div class="flex flex-col gap-3">

                            <form :action="deleteAction" method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full py-3 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl shadow-lg">

                                    YA, HAPUS PERMANEN

                                </button>

                            </form>


                            <button
                                @click="deleteModal = false"
                                class="w-full py-3 bg-gray-50 text-gray-500 font-bold rounded-xl">

                                BATALKAN

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </template>

    </div>

</x-app-layout>