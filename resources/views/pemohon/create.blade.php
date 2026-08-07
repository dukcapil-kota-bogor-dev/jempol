<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 px-4 sm:px-0">
                <div>
                    <h4 class="text-2xl font-bold text-gray-800 tracking-tight">Formulir Pendaftaran JEMPOL-BAHAGIA</h4>
                    <p class="text-sm text-gray-500 mt-1">Input data warga untuk layanan jemput bola perekaman KTP-el.</p>
                </div>
                
                <a href="{{ route('pemohon.index') }}" 
                   class="inline-flex items-center justify-center px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-bold rounded-xl transition-all duration-200 uppercase tracking-widest shadow-sm">
                    <i class="fas fa-arrow-left mr-2 text-indigo-500"></i>
                    Kembali
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-200">
                <form action="{{ route('pemohon.store') }}" method="POST" class="p-6 md:p-10">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-x-8 gap-y-6">
                        
                        <div class="md:col-span-8">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">Jenis Permohonan</label>
                            <select name="jenis_input" id="jenis_input" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm font-medium transition-all">
                                <option value="non_kelurahan">Non Kelurahan (Langsung)</option>
                                <option value="kelurahan">Lewat Kelurahan</option>
                            </select>
                        </div>

                        <div class="md:col-span-4">
    <label class="block text-xs font-bold uppercase text-gray-500 mb-2 tracking-widest">Tanggal Permohonan</label>
    <input type="date" name="tanggal_permohonan" 
        value="{{ old('tanggal_permohonan', date('Y-m-d')) }}"
        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
</div>

                        <div id="input_khusus_kelurahan" class="md:col-span-12 p-5 bg-indigo-50/30 rounded-xl border border-indigo-100 border-dashed" style="display: none;">
                            <div>
                                <label class="block text-xs font-bold uppercase text-indigo-600 mb-2">No. Pemohon</label>
                                <input type="text" name="no_pemohon" 
                                    class="w-full rounded-lg border-indigo-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-indigo-300 text-sm" 
                                    placeholder="Contoh: 001/2026">
                            </div>
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">NIK</label>
                            <input type="text" name="nik" maxlength="16"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm @error('nik') border-red-500 @enderror"
                                placeholder="Kosongkan jika tidak ada"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            @error('nik') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-8">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm uppercase">
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" required
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
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Kelurahan</label>
                            <select name="kelurahan" id="kelurahan" required disabled
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm disabled:bg-gray-50 disabled:cursor-not-allowed">
                                <option value="">-- Pilih Kelurahan --</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 text-center">RT</label>
                            <input type="text" name="rt" maxlength="3" placeholder="000" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-center">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2 text-center">RW</label>
                            <input type="text" name="rw" maxlength="3" placeholder="000" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-center">
                        </div>

                        <div class="md:col-span-6">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Status Kondisi</label>
                            <select name="status_pemohon" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                <option value="">Pilih Status</option>
                                <option value="lansia">Lansia</option>
                                <option value="sakit">Sakit</option>
                                <option value="ODGJ">ODGJ</option>
                                <option value="disabilitas">Disabilitas</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        
                    </div>

                    <div class="mt-12 flex items-center justify-end gap-4 border-t border-gray-100 pt-8">
                        <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-200 transition-all shadow-lg hover:shadow-indigo-200 active:scale-95">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Data Pemohon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisInput = document.getElementById('jenis_input');
            const divKelurahan = document.getElementById('input_khusus_kelurahan');
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

            jenisInput.addEventListener('change', function() {
                divKelurahan.style.display = (this.value === 'kelurahan') ? 'block' : 'none';
            });

            kecSelect.addEventListener('change', function() {
                const selectedKec = this.value;
                kelSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
                
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