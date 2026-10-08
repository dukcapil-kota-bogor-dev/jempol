<x-app-layout>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-4 sm:px-0">

                <div>

                    <h4 class="text-2xl font-bold text-gray-800 tracking-tight">
                        Edit Data Goes To School
                    </h4>

                    <p class="text-sm text-gray-500 mt-1">
                        Lakukan perubahan pada informasi kegiatan Goes To School
                    </p>

                </div>

                <a href="{{ route('goes_to_school.index') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-all duration-200 uppercase tracking-widest shadow-sm">

                    <i class="fas fa-arrow-left mr-2 text-indigo-500"></i>

                    Kembali

                </a>

            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">

                <form action="{{ route('goes_to_school.update', $goesToSchool->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="p-6 md:p-10">

                    @csrf

                    @method('PUT')


                    <div class="grid grid-cols-1 md:grid-cols-12 gap-x-8 gap-y-6">


                        {{-- NAMA SEKOLAH --}}

                        <div class="md:col-span-8">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">
                                Nama Sekolah
                            </label>

                            <input type="text"
                                   name="nama_sekolah"
                                   value="{{ old('nama_sekolah', $goesToSchool->nama_sekolah) }}"
                                   required
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm uppercase">

                            @error('nama_sekolah')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- RENCANA PELAKSANAAN --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">
                                Renacan Pelaksanaan
                            </label>

                            <input type="text"
                                name="rencana_pelaksanaan"
                                value="{{ old('rencana_pelaksanaan', $goesToSchool->rencana_pelaksanaan) }}"
                                placeholder="Contoh: 08.00 - 12.00"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('rencana_pelaksanaan')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>

                        {{-- JUMLAH TARGET --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Jumlah Target
                            </label>

                            <input type="number"
                                   name="jumlah_target"
                                   value="{{ old('jumlah_target', $goesToSchool->jumlah_target) }}"
                                   min="0"
                                   required
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('jumlah_target')
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
                                   value="{{ old('rencana_pelaksanaan', $goesToSchool->rencana_pelaksanaan) }}"
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
                                        {{ old('kecamatan', $goesToSchool->kecamatan) == $kec ? 'selected' : '' }}>
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


                        {{-- TEREKAM --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Terekam
                            </label>

                            <input type="number"
                                   name="terekam"
                                   value="{{ old('terekam', $goesToSchool->terekam) }}"
                                   min="0"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('terekam')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- TEREKAM GAGAL --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Terekam Gagal
                            </label>

                            <input type="number"
                                   name="terekam_gagal"
                                   value="{{ old('terekam_gagal', $goesToSchool->terekam_gagal) }}"
                                   min="0"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('terekam_gagal')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- KURANG DARI 16 TAHUN --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Kurang Dari 16 Tahun
                            </label>

                            <input type="number"
                                   name="kurang_dari_16_tahun"
                                   value="{{ old('kurang_dari_16_tahun', $goesToSchool->kurang_dari_16_tahun) }}"
                                   min="0"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('kurang_dari_16_tahun')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- SUDAH PUNYA KTP --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Sudah Punya KTP
                            </label>

                            <input type="number"
                                   name="sudah_punya"
                                   value="{{ old('sudah_punya', $goesToSchool->sudah_punya) }}"
                                   min="0"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('sudah_punya')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- TIDAK HADIR --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Tidak Hadir
                            </label>

                            <input type="number"
                                   name="tidak_hadir"
                                   value="{{ old('tidak_hadir', $goesToSchool->tidak_hadir) }}"
                                   min="0"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('tidak_hadir')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                    </div>


                        {{-- AKTIVASI IKD --}}

                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Aktivasi IKD
                            </label>

                            <input type="number"
                                   name="aktivasi_ikd"
                                   value="{{ old('aktivasi_ikd', $goesToSchool->aktivasi_ikd) }}"
                                   min="0"
                                   class="w-full rounded-lg border-purple-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 text-sm">

                            @error('aktivasi_ikd')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                    </div>



                    <div class="mt-12 flex items-center justify-end gap-4 border-t border-gray-100 pt-8">

                        <button type="button"
                                onclick="window.history.back()"
                                class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest mr-4">

                            Batal

                        </button>


                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-all shadow-lg hover:shadow-indigo-200 active:scale-95">

                            <i class="fas fa-save mr-2"></i>

                            Simpan Perubahan

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

            const initialKel = "{{ $goesToSchool->kelurahan }}";


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