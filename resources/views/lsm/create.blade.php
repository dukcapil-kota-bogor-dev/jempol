<x-app-layout>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-4 sm:px-0">
            <div>
                <h4 class="text-2xl font-bold text-gray-800 tracking-tight">Formulir Pelayanan LSM</h4>
                <p class="text-sm text-gray-500 mt-1">Input data kegiatan pelayanan LSM.</p>
            </div>

            <a href="{{ route('lsm.index') }}"
               class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-all duration-200 uppercase tracking-widest shadow-sm">
                <i class="fas fa-arrow-left mr-2 text-indigo-500"></i>
                Kembali
            </a>

        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
            <form action="{{ route('lsm.store') }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-10">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Kecamatan --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            Kecamatan
                        </label>

                        <select
                            name="kecamatan"
                            id="kecamatan"
                            required
                            class="w-full h-11 px-4 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 focus:ring-indigo-500 focus:border-indigo-500"
                        >
                            <option value="">-- Pilih Kecamatan --</option>
                            <option value="Bogor Barat">Bogor Barat</option>
                            <option value="Bogor Selatan">Bogor Selatan</option>
                            <option value="Bogor Tengah">Bogor Tengah</option>
                            <option value="Bogor Timur">Bogor Timur</option>
                            <option value="Bogor Utara">Bogor Utara</option>
                            <option value="Tanah Sareal">Tanah Sareal</option>
                            <option value="Luar Domisili">Luar Domisili</option>
                        </select>

                        @error('kecamatan')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kelurahan --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            Kelurahan
                        </label>

                        <select
                            name="kelurahan"
                            id="kelurahan"
                            required
                            disabled
                            class="w-full h-11 px-4 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 focus:ring-indigo-500 focus:border-indigo-500 disabled:bg-gray-50 disabled:cursor-not-allowed"
                        >
                            <option value="">-- Pilih Kelurahan --</option>
                        </select>

                        @error('kelurahan')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jumlah Sasaran --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            Jumlah Sasaran
                        </label>

                        <input
                            type="number"
                            name="jumlah_sasaran"
                            min="0"
                            value="{{ old('jumlah_sasaran', 0) }}"
                            required
                            class="w-full h-11 px-4 bg-white border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="0"
                        >

                        @error('jumlah_sasaran')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Pelaksanaan --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            Tanggal Pelaksanaan
                        </label>

                        <input
                            type="date"
                            name="tanggal_pelaksanaan"
                            value="{{ old('tanggal_pelaksanaan', date('Y-m-d')) }}"
                            required
                            class="w-full h-11 px-4 bg-white border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                        >

                        @error('tanggal_pelaksanaan')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- HASIL PELAYANAN --}}
                <div class="mt-6 p-6 bg-indigo-50/30 border border-indigo-100 rounded-xl">

                    <h5 class="text-sm font-bold text-indigo-700 uppercase tracking-widest mb-5">
                        Hasil Pelayanan
                    </h5>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                        {{-- Terekam --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">
                                Terekam
                            </label>

                            <input
                                type="number"
                                name="terekam"
                                min="0"
                                value="{{ old('terekam', 0) }}"
                                required
                                class="w-full h-11 px-4 bg-white border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            >

                            @error('terekam')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Gagal Terekam --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">
                                Gagal Terekam
                            </label>

                            <input
                                type="number"
                                name="gagal_rekam"
                                min="0"
                                value="{{ old('gagal_rekam', 0) }}"
                                required
                                class="w-full h-11 px-4 bg-white border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            >

                            @error('gagal_rekam')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Sudah Memiliki KTP --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">
                                Sudah Memiliki KTP
                            </label>

                            <input
                                type="number"
                                name="sudah_memiliki_ktp"
                                min="0"
                                value="{{ old('sudah_memiliki_ktp', 0) }}"
                                required
                                class="w-full h-11 px-4 bg-white border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            >

                            @error('sudah_memiliki_ktp')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tidak Hadir --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase mb-2">
                                Tidak Hadir
                            </label>

                            <input
                                type="number"
                                name="tidak_hadir"
                                min="0"
                                value="{{ old('tidak_hadir', 0) }}"
                                required
                                class="w-full h-11 px-4 bg-white border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                            >

                            @error('tidak_hadir')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- DOKUMENTASI --}}
                <div class="mt-6 p-6 bg-gray-50 rounded-xl border border-gray-200">

                    <h5 class="text-sm font-bold text-gray-700 uppercase tracking-widest mb-5">
                        Dokumentasi Kegiatan
                    </h5>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Foto 1 --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                                Dokumentasi Foto 1
                            </label>

                            <input
                                type="file"
                                name="foto_1"
                                accept="image/*"
                                class="w-full h-11 px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 file:mr-4 file:py-1.5 file:px-4 file:rounded-md file:border-0 file:bg-gray-100 file:text-gray-700"
                                required
                            >

                            <p class="text-xs text-gray-400 mt-1">
                                Format JPG, JPEG, PNG. Maksimal 2 MB.
                            </p>

                            @error('foto_1')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Foto 2 --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-2">
                                Dokumentasi Foto 2
                            </label>

                            <input
                                type="file"
                                name="foto_2"
                                accept="image/*"
                                class="w-full h-11 px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm text-gray-600 file:mr-4 file:py-1.5 file:px-4 file:rounded-md file:border-0 file:bg-gray-100 file:text-gray-700"
                                required
                            >

                            <p class="text-xs text-gray-400 mt-1">
                                Format JPG, JPEG, PNG. Maksimal 2 MB.
                            </p>

                            @error('foto_2')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="mt-12 flex items-center justify-end gap-4 border-t border-gray-100 pt-8">
                    <button type="submit"
                            class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-all shadow-lg hover:shadow-indigo-200 active:scale-95">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Data Lsm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kecSelect = document.getElementById('kecamatan');
        const kelSelect = document.getElementById('kelurahan');

        const dataWilayah = {
            "Bogor Barat": ["Balungbangjaya", "Bubulak", "Cilendek Barat", "Cilendek Timur", "Curug", "Curugmekar", "Gunungbatu", "Loji", "Margajaya", "Menteng", "Pasirjaya", "Pasirkuda", "Pasirmulya", "Semplak", "Sindangbarang", "Situgede"],
            "Bogor Selatan": ["Batutulis", "Bojongkerta", "Bondongan", "Cikaret", "Cipaku", "Empang", "Genteng", "Harjasari", "Kertamaya", "Lawanggintung", "Muarasari", "Mulyaharja", "Pakuan", "Pamoyanan", "Rancamaya", "Ranggamekar"],
            "Bogor Tengah": ["Babakan", "Babakan Pasar", "Cibogor", "Ciwaringin", "Gudang", "Kebon Kalapa", "Pabaton", "Paledang", "Panaragan", "Sempur", "Tegallega"],
            "Bogor Timur": ["Baranangsiang", "Katulampa", "Sindangrasa", "Sindangsari", "Sukasari", "Tajur"],
            "Bogor Utara": ["Bantarjati", "Cibuluh", "Ciluar", "Cimahpar", "Ciparigi", "Kedunghalang", "Tanahbaru", "Tegal Gundil"],
            "Tanah Sareal": ["Cibadak", "Kayumanis", "Kebon Pedes", "Kedung Badak", "Kedung Jaya", "Kedung Waringin", "Kencana", "Mekarwangi", "Sukadamai", "Sukaresmi", "Tanah Sareal"],
            "Luar Domisili": ["Luar Domisili"]
        };

        kecSelect.addEventListener('change', function() {
            const selectedKec = this.value;

            kelSelect.innerHTML =
                '<option value="">-- Pilih Kelurahan --</option>';

            if (selectedKec && dataWilayah[selectedKec]) {
                kelSelect.disabled = false;

                dataWilayah[selectedKec].sort().forEach(function(kel) {
                    const opt = document.createElement('option');
                    opt.value = kel;
                    opt.textContent = kel;
                    kelSelect.appendChild(opt);
                });
            } else {
                kelSelect.disabled = true;
            }
        });
    });
</script>
</x-app-layout>
