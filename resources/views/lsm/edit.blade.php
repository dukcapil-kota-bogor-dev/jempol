<x-app-layout>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-4 sm:px-0">

                <div>

                    <h4 class="text-2xl font-bold text-gray-800 tracking-tight">
                        Edit Data LSM
                    </h4>

                    <p class="text-sm text-gray-500 mt-1">
                        Lakukan perubahan pada informasi kegiatan pelayanan LSM
                    </p>

                </div>

                <a href="{{ route('lsm.index') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-all duration-200 uppercase tracking-widest shadow-sm">

                    <i class="fas fa-arrow-left mr-2 text-indigo-500"></i>

                    Kembali

                </a>

            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">

                <form action="{{ route('lsm.update', $lsm->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="p-6 md:p-10">

                    @csrf

                    @method('PUT')


                    <div class="grid grid-cols-1 md:grid-cols-12 gap-x-8 gap-y-6">


                        {{-- JUMLAH SASARAN --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Jumlah Sasaran
                            </label>

                            <input type="number"
                                   name="jumlah_sasaran"
                                   value="{{ old('jumlah_sasaran', $lsm->jumlah_sasaran) }}"
                                   min="0"
                                   required
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('jumlah_sasaran')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- RENCANA PELAKSANAAN --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">
                                Rencana Pelaksanaan
                            </label>

                            <input type="date"
                                   name="rencana_pelaksanaan"
                                   value="{{ old('rencana_pelaksanaan', $lsm->rencana_pelaksanaan) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('rencana_pelaksanaan')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- KECAMATAN --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Kecamatan
                            </label>

                            <select name="kecamatan"
                                    id="kecamatan"
                                    required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                                <option value="">-- Pilih Kecamatan --</option>

                                @foreach([
                                    'Bogor Barat',
                                    'Bogor Selatan',
                                    'Bogor Tengah',
                                    'Bogor Timur',
                                    'Bogor Utara',
                                    'Tanah Sareal',
                                    'Luar Domisili'
                                ] as $kec)

                                    <option value="{{ $kec }}"
                                        {{ old('kecamatan', $lsm->kecamatan) == $kec ? 'selected' : '' }}>
                                        {{ $kec }}
                                    </option>

                                @endforeach

                            </select>

                            @error('kecamatan')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- KELURAHAN --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">
                                Kelurahan
                            </label>

                            <select name="kelurahan"
                                    id="kelurahan"
                                    required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm disabled:bg-gray-50 disabled:cursor-not-allowed">

                                <option value="">
                                    -- Pilih Kelurahan --
                                </option>

                            </select>

                            @error('kelurahan')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                    </div>


                    {{-- HASIL PELAYANAN LSM --}}

                    <div class="mt-8 p-6 bg-indigo-50/30 border border-indigo-100 rounded-xl">

                        <h5 class="text-sm font-bold text-indigo-700 uppercase tracking-widest mb-5">
                            Hasil Pelayanan
                        </h5>


                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">


                            {{-- TEREKAM --}}

                            <div>

                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                    Terekam
                                </label>

                                <input type="number"
                                       name="terekam"
                                       value="{{ old('terekam', $lsm->terekam) }}"
                                       min="0"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                                @error('terekam')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror

                            </div>


                            {{-- GAGAL REKAM --}}

                            <div>

                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                    Gagal Rekam
                                </label>

                                <input type="number"
                                       name="gagal_rekam"
                                       value="{{ old('gagal_rekam', $lsm->gagal_rekam) }}"
                                       min="0"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                                @error('gagal_rekam')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror

                            </div>


                            {{-- SUDAH MEMILIKI KTP --}}

                            <div>

                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                    Sudah Memiliki KTP
                                </label>

                                <input type="number"
                                       name="sudah_memiliki_ktp"
                                       value="{{ old('sudah_memiliki_ktp', $lsm->sudah_memiliki_ktp) }}"
                                       min="0"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                                @error('sudah_memiliki_ktp')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror

                            </div>


                            {{-- TIDAK HADIR --}}

                            <div>

                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                    Tidak Hadir
                                </label>

                                <input type="number"
                                       name="tidak_hadir"
                                       value="{{ old('tidak_hadir', $lsm->tidak_hadir) }}"
                                       min="0"
                                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                                @error('tidak_hadir')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror

                            </div>


                        </div>

                    </div>


                <div class="mt-12 flex items-center justify-end gap-4 border-t border-gray-100 pt-8">

                    <button type="button"
                            onclick="window.history.back()"
                            class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest mr-4">

                        Batal

                    </button>


                {{-- TOMBOL SIMPAN BIASA --}}
                <button type="submit"
                        name="action"
                        value="save"
                        class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-all shadow-lg hover:shadow-indigo-200 active:scale-95">

                    <i class="fas fa-save mr-2"></i>

                    Simpan Perubahan

                </button>


                {{-- TOMBOL SIMPAN & SELESAIKAN --}}
                <button type="submit"
                        name="action"
                        value="finish"
                        class="inline-flex items-center px-8 py-3 bg-emerald-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-200 transition-all shadow-lg hover:shadow-emerald-200 active:scale-95">

                     <i class="fas fa-check mr-2"></i>

                        Simpan & Selesaikan

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

                "Bogor Barat": [
                    "Balungbangjaya",
                    "Bubulak",
                    "Cilendek Barat",
                    "Cilendek Timur",
                    "Curug",
                    "Curugmekar",
                    "Gunungbatu",
                    "Loji",
                    "Margajaya",
                    "Menteng",
                    "Pasirjaya",
                    "Pasirkuda",
                    "Pasirmulya",
                    "Semplak",
                    "Sindangbarang",
                    "Situgede"
                ],

                "Bogor Selatan": [
                    "Batutulis",
                    "Bojongkerta",
                    "Bondongan",
                    "Cikaret",
                    "Cipaku",
                    "Empang",
                    "Genteng",
                    "Harjasari",
                    "Kertamaya",
                    "Lawanggintung",
                    "Muarasari",
                    "Mulyaharja",
                    "Pakuan",
                    "Pamoyanan",
                    "Rancamaya",
                    "Ranggamekar"
                ],

                "Bogor Tengah": [
                    "Babakan",
                    "Babakan Pasar",
                    "Cibogor",
                    "Ciwaringin",
                    "Gudang",
                    "Kebon Kalapa",
                    "Pabaton",
                    "Paledang",
                    "Panaragan",
                    "Sempur",
                    "Tegallega"
                ],

                "Bogor Timur": [
                    "Baranangsiang",
                    "Katulampa",
                    "Sindangrasa",
                    "Sindangsari",
                    "Sukasari",
                    "Tajur"
                ],

                "Bogor Utara": [
                    "Bantarjati",
                    "Cibuluh",
                    "Ciluar",
                    "Cimahpar",
                    "Ciparigi",
                    "Kedunghalang",
                    "Tanahbaru",
                    "Tegal Gundil"
                ],

                "Tanah Sareal": [
                    "Cibadak",
                    "Kayumanis",
                    "Kebon Pedes",
                    "Kedung Badak",
                    "Kedung Jaya",
                    "Kedung Waringin",
                    "Kencana",
                    "Mekarwangi",
                    "Sukadamai",
                    "Sukaresmi",
                    "Tanah Sareal"
                ],

                "Luar Domisili": [
                    "Luar Domisili"
                ]

            };


            // Inisialisasi Kelurahan jika sudah ada data

            const initialKec = kecSelect.value;

            const initialKel = "{{ $lsm->kelurahan }}";


            if (initialKec && dataWilayah[initialKec]) {

                kelSelect.disabled = false;

                kelSelect.innerHTML =
                    '<option value="">-- Pilih Kelurahan --</option>';

                dataWilayah[initialKec].sort().forEach(kel => {

                    const opt = document.createElement('option');

                    opt.value = kel;

                    opt.textContent = kel;

                    if (kel === initialKel) {
                        opt.selected = true;
                    }

                    kelSelect.appendChild(opt);

                });

            }


            kecSelect.addEventListener('change', function() {

                const selectedKec = this.value;

                kelSelect.innerHTML =
                    '<option value="">-- Pilih Kelurahan --</option>';

                if (selectedKec && dataWilayah[selectedKec]) {

                    kelSelect.disabled = false;

                    dataWilayah[selectedKec].sort().forEach(kel => {

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