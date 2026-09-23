<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-4 sm:px-0">

                <div>
                    <h4 class="text-2xl font-bold text-gray-800 tracking-tight">
                        Formulir Pendaftaran GOES TO SCHOOL
                    </h4>

                    <p class="text-sm text-gray-500 mt-1">
                        Input data kegiatan Goes To School dan hasil perekaman KTP-el.
                    </p>
                </div>

                <a href="{{ route('goes_to_school.index') }}"
                   class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-all duration-200 uppercase tracking-widest shadow-sm">

                    <i class="fas fa-arrow-left mr-2 text-indigo-500"></i>
                    Kembali

                </a>

            </div>


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">

                <form action="{{ route('goes_to_school.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="p-6 md:p-10">

                    @csrf


                    <div class="grid grid-cols-1 md:grid-cols-12 gap-x-8 gap-y-6">


                        {{-- NAMA SEKOLAH --}}
                        <div class="md:col-span-8">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">
                                Nama Sekolah
                            </label>

                            <input type="text"
                                   name="nama_sekolah"
                                   value="{{ old('nama_sekolah') }}"
                                   required
                                   placeholder="Contoh: SMA Negeri 1 Bogor"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm uppercase">

                            @error('nama_sekolah')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- JADWAL PELAKSANAAN --}}
                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">
                                Jadwal Pelaksanaan
                            </label>

                            <input type="text"
                                   name="jadwal_pelaksanaan"
                                   value="{{ old('jadwal_pelaksanaan') }}"
                                   placeholder="Contoh: 08.00 - 12.00"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('jadwal_pelaksanaan')
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
                                   value="{{ old('jumlah_target', 0) }}"
                                   min="0"
                                   required
                                   placeholder="0"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('jumlah_target')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- TANGGAL PELAKSANAAN --}}
                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">
                                Tanggal Pelaksanaan
                            </label>

                            <input type="date"
                                   name="tanggal_pelaksanaan"
                                   value="{{ old('tanggal_pelaksanaan', date('Y-m-d')) }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                            @error('tanggal_pelaksanaan')
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
                        <div class="md:col-span-4">

                            <label class="block text-xs font-bold text-gray-500 mb-2 uppercase">
                                Kelurahan
                            </label>

                            <select name="kelurahan"
                                    id="kelurahan"
                                    required
                                    disabled
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm disabled:bg-gray-50 disabled:cursor-not-allowed">

                                <option value="">
                                    -- Pilih Kelurahan --
                                </option>

                            </select>

                            @error('kelurahan')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- HASIL PEREKAMAN --}}
                        <div class="md:col-span-12">

                            <div class="p-5 bg-indigo-50/30 rounded-xl border border-indigo-100">

                                <h5 class="text-sm font-bold text-indigo-600 uppercase tracking-widest mb-4">
                                    Hasil Perekaman
                                </h5>


                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">


                                    {{-- TEREKAM --}}
                                    <div>

                                        <label class="block text-xs font-bold text-gray-500 mb-2">
                                            Terekam
                                        </label>

                                        <input type="number"
                                               name="terekam"
                                               value="{{ old('terekam', 0) }}"
                                               min="0"
                                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-center">

                                    </div>


                                    {{-- GAGAL TEREKAM --}}
                                    <div>

                                        <label class="block text-xs font-bold text-gray-500 mb-2">
                                            Gagal Terekam
                                        </label>

                                        <input type="number"
                                               name="terekam_gagal"
                                               value="{{ old('terekam_gagal', 0) }}"
                                               min="0"
                                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-center">

                                    </div>


                                    {{-- KURANG DARI 16 TAHUN --}}
                                    <div>

                                        <label class="block text-xs font-bold text-gray-500 mb-2">
                                            Kurang Dari 16 Tahun
                                        </label>

                                        <input type="number"
                                               name="kurang_dari_16_tahun"
                                               value="{{ old('kurang_dari_16_tahun', 0) }}"
                                               min="0"
                                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-center">

                                    </div>


                                    {{-- SUDAH PUNYA --}}
                                    <div>

                                        <label class="block text-xs font-bold text-gray-500 mb-2">
                                            Sudah Punya KTP
                                        </label>

                                        <input type="number"
                                               name="sudah_punya"
                                               value="{{ old('sudah_punya', 0) }}"
                                               min="0"
                                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-center">

                                    </div>


                                    {{-- TIDAK HADIR --}}
                                    <div>

                                        <label class="block text-xs font-bold text-gray-500 mb-2">
                                            Tidak Hadir
                                        </label>

                                        <input type="number"
                                               name="tidak_hadir"
                                               value="{{ old('tidak_hadir', 0) }}"
                                               min="0"
                                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-center">

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- STATUS AKTIVASI IKD --}}
                        <div class="md:col-span-6">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Status Aktivasi IKD
                            </label>

                            <select name="status_ikd"
                                    required
                                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">

                                <option value="">
                                    -- Pilih Status IKD --
                                </option>

                                <option value="sudah_aktivasi">
                                    Sudah Aktivasi IKD
                                </option>

                                <option value="belum_aktivasi">
                                    Belum Aktivasi IKD
                                </option>

                            </select>

                            @error('status_ikd')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- FOTO 1 --}}
                        <div class="md:col-span-6">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Upload Kegiatan 1
                            </label>

                            <input type="file"
                                   name="foto_1"
                                   accept="image/jpeg,image/png,image/jpg"
                                   class="w-full rounded-lg border border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-2">

                            @error('foto_1')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                        {{-- FOTO 2 --}}
                        <div class="md:col-span-6">

                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">
                                Upload Kegiatan 2
                            </label>

                            <input type="file"
                                   name="foto_2"
                                   accept="image/jpeg,image/png,image/jpg"
                                   class="w-full rounded-lg border border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-2">

                            @error('foto_2')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror

                        </div>


                    </div>


                    {{-- TOMBOL SIMPAN --}}
                    <div class="mt-12 flex items-center justify-end gap-4 border-t border-gray-100 pt-8">

                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-all shadow-lg hover:shadow-indigo-200 active:scale-95">

                            <i class="fas fa-save mr-2"></i>

                            Simpan Data Goes To School

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

                "Bogor Barat":   ["Balungbangjaya","Bubulak","Cilendek Barat","Cilendek Timur","Curug","Curugmekar","Gunungbatu","Loji","Margajaya","Menteng","Pasirjaya","Pasirkuda","Pasirmulya","Semplak","Sindangbarang","Situgede"],
                "Bogor Selatan": ["Batutulis","Bojongkerta","Bondongan","Cikaret","Cipaku","Empang","Genteng","Harjasari","Kertamaya","Lawanggintung","Muarasari","Mulyaharja","Pakuan","Pamoyanan","Rancamaya","Ranggamekar"],
                "Bogor Tengah":  ["Babakan","Babakan Pasar","Cibogor","Ciwaringin","Gudang","Kebon Kalapa","Pabaton","Paledang","Panaragan","Sempur","Tegallega"],
                "Bogor Timur":   ["Baranangsiang","Katulampa","Sindangrasa","Sindangsari","Sukasari","Tajur"],
                "Bogor Utara":   ["Bantarjati","Cibuluh","Ciluar","Cimahpar","Ciparigi","Kedunghalang","Tanahbaru","Tegal Gundil"],
                "Tanah Sareal":  ["Cibadak","Kayumanis","Kebon Pedes","Kedung Badak","Kedung Jaya","Kedung Waringin","Kencana","Mekarwangi","Sukadamai","Sukaresmi","Tanah Sareal"],
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