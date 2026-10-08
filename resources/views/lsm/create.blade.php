<x-app-layout>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-4 sm:px-0">

                <div>
                    <h4 class="text-2xl font-bold text-gray-800 tracking-tight">
                        Formulir Pendaftaran LSM
                    </h4>

                    <p class="text-sm text-gray-500 mt-1">
                        Input data kegiatan pelayanan LSM.
                    </p>
                </div>

                <a href="{{ route('lsm.index') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-all duration-200 uppercase tracking-widest shadow-sm">

                    <i class="fas fa-arrow-left mr-2 text-indigo-500"></i>
                    Kembali

                </a>

            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">

                <form action="{{ route('lsm.store') }}"
                      method="POST"
                      class="p-6 md:p-10">

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        {{-- KECAMATAN --}}
                        <div>

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">
                                Kecamatan
                            </label>

                            <select
                                name="kecamatan"
                                id="kecamatan"
                                required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
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


                        {{-- KELURAHAN --}}
                        <div>

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">
                                Kelurahan
                            </label>

                            <select
                                name="kelurahan"
                                id="kelurahan"
                                required
                                disabled
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm disabled:bg-gray-50 disabled:cursor-not-allowed"
                            >

                                <option value="">
                                    -- Pilih Kelurahan --
                                </option>

                            </select>

                            @error('kelurahan')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- JUMLAH SASARAN --}}
                        <div>

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">
                                Jumlah Sasaran
                            </label>

                            <input
                                type="number"
                                name="jumlah_sasaran"
                                value="{{ old('jumlah_sasaran', 0) }}"
                                min="0"
                                required
                                placeholder="0"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            >

                            @error('jumlah_sasaran')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                            {{-- RENCANA PELAKSANAAN --}}
                            <div>

                                <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">
                                    Rencana Pelaksanaan
                                </label>

                                <input
                                    type="date"
                                    name="rencana_pelaksanaan"
                                    value="{{ old('rencana_pelaksanaan', date('Y-m-d')) }}"
                                    required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                >

                                @error('rencana_pelaksanaan')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror

                            </div>                            
                        </div>


                    {{-- TOMBOL SIMPAN --}}
                    <div class="mt-12 flex items-center justify-end gap-4 border-t border-gray-100 pt-8">

                        <button
                            type="submit"
                            class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-all shadow-lg hover:shadow-indigo-200 active:scale-95">

                            <i class="fas fa-save mr-2"></i>
                            Simpan Data LSM

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    {{-- SCRIPT KELURAHAN --}}
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