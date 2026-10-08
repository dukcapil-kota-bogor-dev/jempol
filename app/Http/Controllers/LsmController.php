<?php

namespace App\Http\Controllers;

use App\Models\lsm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use Carbon\Carbon;

class lsmController extends Controller
{
    /**
     * Menampilkan daftar LSM dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        // Ambil input pencarian
        $search = $request->query('search');

        // Data yang masih proses selalu berada di atas
        $query = lsm::orderByRaw(
            "CASE WHEN status_progress = 'proses' THEN 0 ELSE 1 END"
        )
            ->orderBy('rencana_pelaksanaan', 'desc')
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->orderBy('created_at', 'desc');

        // Fitur pencarian
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kecamatan', 'like', "%{$search}%")
                    ->orWhere('kelurahan', 'like', "%{$search}%")
                    ->orWhere('rencana_pelaksanaan', 'like', "%{$search}%")
                    ->orWhere('tanggal_pelaksanaan', 'like', "%{$search}%");
            });
        }

        $lsm = $query->get();

        return view('lsm.index', compact('lsm'));
    }


    /**
     * Menampilkan form tambah data LSM.
     */
    public function create()
    {
        return view('lsm.create');
    }


    /**
     * Menyimpan data LSM baru.
     *
     * Saat pertama kali dibuat:
     * - rencana_pelaksanaan = tanggal yang direncanakan
     * - tanggal_pelaksanaan = masih kosong
     * - status_progress = proses
     */
    public function store(Request $request)
    {
        $request->validate([
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'jumlah_sasaran' => 'required|integer|min:0',

            // Tanggal yang direncanakan
            'rencana_pelaksanaan' => 'required|date',

            // Tanggal sebenarnya baru diisi saat selesai
            'tanggal_pelaksanaan' => 'nullable|date',

            'terekam' => 'nullable|integer|min:0',
            'gagal_rekam' => 'nullable|integer|min:0',
            'kurang_dari_16_tahun' => 'nullable|integer|min:0',
            'sudah_memiliki_ktp' => 'nullable|integer|min:0',
            'tidak_hadir' => 'nullable|integer|min:0',

            'foto_1' => 'nullable|image|mimes:jpeg,png,jpg',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        // Simpan foto kegiatan
        $foto1Path = null;
        $foto2Path = null;

        if ($request->hasFile('foto_1')) {
            $foto1Path = $request->file('foto_1')
                ->store('dokumentasi_lsm', 'public');
        }

        if ($request->hasFile('foto_2')) {
            $foto2Path = $request->file('foto_2')
                ->store('dokumentasi_lsm', 'public');
        }

        // Simpan data LSM
        lsm::create([
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'jumlah_sasaran' => $request->jumlah_sasaran,

            // Tanggal yang direncanakan
            'rencana_pelaksanaan' => $request->rencana_pelaksanaan,

            // Masih kosong karena pelayanan belum selesai
            'tanggal_pelaksanaan' => null,

            'terekam' => $request->terekam ?? 0,
            'gagal_rekam' => $request->gagal_rekam ?? 0,
            'kurang_dari_16_tahun' => $request->kurang_dari_16_tahun ?? 0,
            'sudah_memiliki_ktp' => $request->sudah_memiliki_ktp ?? 0,
            'tidak_hadir' => $request->tidak_hadir ?? 0,

            'foto_1' => $foto1Path,
            'foto_2' => $foto2Path,

            // Status awal
            'status_progress' => 'proses',
        ]);

        return redirect()
            ->route('lsm.index')
            ->with('success', 'Data LSM berhasil diajukan!');
    }


    /**
     * Menampilkan form edit data.
     */
    public function edit($id)
    {
        $lsm = lsm::findOrFail($id);

        // Data selesai tidak dapat diedit
        if ($lsm->status_progress === 'selesai') {
            return redirect()
                ->route('lsm.index')
                ->with(
                    'error',
                    'Akses ditolak! Data yang sudah selesai telah dikunci.'
                );
        }

        return view(
            'lsm.edit',
            compact('lsm')
        );
    }


    /**
     * Update data LSM.
     *
     * action = finish
     * berarti pelayanan diselesaikan.
     */
    public function update(Request $request, $id)
    {
        $lsm = lsm::findOrFail($id);

        // Data yang sudah selesai tidak boleh diubah lagi
        if ($lsm->status_progress === 'selesai') {
            return redirect()
                ->route('lsm.index')
                ->with(
                    'error',
                    'Perubahan ditolak! Data ini sudah berstatus selesai.'
                );
        }

        // Menentukan tombol yang ditekan
        $action = $request->input('action');

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            /*
             * Kalau tombol SIMPAN & SELESAIKAN ditekan,
             * tanggal pelaksanaan wajib diisi.
             */
            'tanggal_pelaksanaan' => $action === 'finish'
                ? 'required|date'
                : 'nullable|date',

            /*
             * Rencana tetap boleh dikirim ketika edit.
             */
            'rencana_pelaksanaan' => 'sometimes|nullable|date',

            'kecamatan' => 'sometimes|nullable|string|max:255',
            'kelurahan' => 'sometimes|nullable|string|max:255',
            'jumlah_sasaran' => 'sometimes|nullable|integer|min:0',

            'terekam' => 'sometimes|nullable|integer|min:0',
            'gagal_rekam' => 'sometimes|nullable|integer|min:0',
            'kurang_dari_16_tahun' => 'sometimes|nullable|integer|min:0',
            'sudah_memiliki_ktp' => 'sometimes|nullable|integer|min:0',
            'tidak_hadir' => 'sometimes|nullable|integer|min:0',

            'foto_1' => 'nullable|image|mimes:jpeg,png,jpg',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        /*
        |--------------------------------------------------------------------------
        | DATA YANG AKAN DIUPDATE
        |--------------------------------------------------------------------------
        */

        $data = [];

        if ($request->has('kecamatan')) {
            $data['kecamatan'] = $request->kecamatan;
        }

        if ($request->has('kelurahan')) {
            $data['kelurahan'] = $request->kelurahan;
        }

        if ($request->has('jumlah_sasaran')) {
            $data['jumlah_sasaran'] = $request->jumlah_sasaran;
        }

        /*
         * rencana pelaksanaan adalah rencana yang direncanakan.
         */
        if ($request->has('rencana_pelaksanaan')) {
            $data['rencana_pelaksanaan'] = $request->rencana_pelaksanaan;
        }

        /*
         * Tanggal pelaksanaan adalah tanggal sebenarnya
         * ketika pelayanan diselesaikan.
         */
        if ($request->has('tanggal_pelaksanaan')) {
            $data['tanggal_pelaksanaan'] = $request->tanggal_pelaksanaan;
        }

        if ($request->has('terekam')) {
            $data['terekam'] = $request->terekam ?? 0;
        }

        if ($request->has('gagal_rekam')) {
            $data['gagal_rekam'] = $request->gagal_rekam ?? 0;
        }

        if ($request->has('kurang_dari_16_tahun')) {
            $data['kurang_dari_16_tahun'] = $request->kurang_dari_16_tahun ?? 0;
        }

        if ($request->has('sudah_memiliki_ktp')) {
            $data['sudah_memiliki_ktp'] = $request->sudah_memiliki_ktp ?? 0;
        }

        if ($request->has('tidak_hadir')) {
            $data['tidak_hadir'] = $request->tidak_hadir ?? 0;
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS PROGRESS
        |--------------------------------------------------------------------------
        */

        if ($action === 'finish') {

            // Klik SIMPAN & SELESAIKAN
            $data['status_progress'] = 'selesai';

        } else {

            // Masih dalam proses
            $data['status_progress'] = 'proses';
        }


        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO 1
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_1')) {

            if ($lsm->foto_1) {
                Storage::disk('public')
                    ->delete($lsm->foto_1);
            }

            $data['foto_1'] = $request->file('foto_1')
                ->store('dokumentasi_lsm', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO 2
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_2')) {

            if ($lsm->foto_2) {
                Storage::disk('public')
                    ->delete($lsm->foto_2);
            }

            $data['foto_2'] = $request->file('foto_2')
                ->store('dokumentasi_lsm', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN KE DATABASE
        |--------------------------------------------------------------------------
        */

        $lsm->update($data);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        if ($action === 'finish') {

            return redirect()
                ->route('lsm.index')
                ->with(
                    'success',
                    'Data LSM berhasil diselesaikan!'
                );
        }

        return redirect()
            ->route('lsm.index')
            ->with(
                'success',
                'Data LSM berhasil diperbarui!'
            );
    }


    /**
     * Download laporan LSM dalam bentuk Word.
     */
    public function downloadDocx($id)
    {
        $lsm = lsm::findOrFail($id);

        $phpWord = new PhpWord();

        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop' => 1200,
            'marginBottom' => 1200,
            'marginLeft' => 1200,
            'marginRight' => 1200,
        ]);

        $centerStyle = [
            'alignment' => Jc::CENTER
        ];


        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */

        $section->addText(
            "Pelayanan LSM",
            [
                'bold' => true,
                'size' => 14
            ],
            $centerStyle
        );


        $section->addText(
            "Kelurahan " .
            $lsm->kelurahan .
            " Kecamatan " .
            str_replace('_', ' ', $lsm->kecamatan),
            [
                'size' => 11
            ],
            $centerStyle
        );

        $section->addTextBreak(1);


        /*
        |--------------------------------------------------------------------------
        | INFORMASI RENCANA & TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($lsm->rencana_pelaksanaan) {

            $section->addText(
                "rencana Pelaksanaan: " .
                Carbon::parse($lsm->rencana_pelaksanaan)
                    ->format('d/m/Y'),
                [
                    'size' => 11
                ],
                $centerStyle
            );
        }

        if ($lsm->tanggal_pelaksanaan) {

            $section->addText(
                "Tanggal Pelaksanaan: " .
                Carbon::parse($lsm->tanggal_pelaksanaan)
                    ->format('d/m/Y'),
                [
                    'size' => 11
                ],
                $centerStyle
            );
        }

        $section->addTextBreak(1);


        /*
        |--------------------------------------------------------------------------
        | FOTO 1
        |--------------------------------------------------------------------------
        */

        if (
            $lsm->foto_1 &&
            Storage::disk('public')->exists($lsm->foto_1)
        ) {

            $section->addImage(
                public_path('storage/' . $lsm->foto_1),
                [
                    'width' => 400,
                    'height' => 240,
                    'alignment' => Jc::CENTER
                ]
            );

            $section->addTextBreak(1);
        }


        /*
        |--------------------------------------------------------------------------
        | FOTO 2
        |--------------------------------------------------------------------------
        */

        if (
            $lsm->foto_2 &&
            Storage::disk('public')->exists($lsm->foto_2)
        ) {

            $section->addImage(
                public_path('storage/' . $lsm->foto_2),
                [
                    'width' => 400,
                    'height' => 240,
                    'alignment' => Jc::CENTER
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | NAMA FILE
        |--------------------------------------------------------------------------
        */

        $bulanTahun = $lsm->tanggal_pelaksanaan
            ? Carbon::parse($lsm->tanggal_pelaksanaan)
                ->translatedFormat('F Y')
            : 'Tanpa Tanggal';

        $fileName =
            $bulanTahun .
            " - " .
            $lsm->kelurahan .
            " (" .
            $lsm->kecamatan .
            " - LSM).docx";


        /*
        |--------------------------------------------------------------------------
        | BUAT FILE WORD
        |--------------------------------------------------------------------------
        */

        $objWriter = IOFactory::createWriter(
            $phpWord,
            'Word2007'
        );

        $tempFile = tempnam(
            sys_get_temp_dir(),
            'phpword_'
        );

        $objWriter->save($tempFile);

        return response()
            ->download(
                $tempFile,
                $fileName
            )
            ->deleteFileAfterSend(true);
    }


    /**
     * Menghapus data LSM.
     */
    public function destroy($id)
    {
        $lsm = lsm::findOrFail($id);

        // Hapus foto 1
        if ($lsm->foto_1) {
            Storage::disk('public')
                ->delete($lsm->foto_1);
        }

        // Hapus foto 2
        if ($lsm->foto_2) {
            Storage::disk('public')
                ->delete($lsm->foto_2);
        }

        // Hapus data LSM
        $lsm->delete();

        return redirect()
            ->route('lsm.index')
            ->with(
                'success',
                'Data LSM berhasil dihapus.'
            );
    }
}