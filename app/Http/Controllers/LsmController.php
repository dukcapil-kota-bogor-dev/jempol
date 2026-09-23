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
        // Ambil input pencarian dari request
        $search = $request->query('search');

        // Query dasar dengan pengurutan
        // Status 'proses' selalu di atas
        $query = lsm::orderByRaw("CASE WHEN status_progress = 'proses' THEN 0 ELSE 1 END")
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->orderBy('created_at', 'desc');

        // Jika ada input pencarian, tambahkan filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kecamatan', 'like', "%{$search}%")
                  ->orWhere('kelurahan', 'like', "%{$search}%")
                  ->orWhere('tanggal_pelaksanaan', 'like', "%{$search}%");
            });
        }

        // Ambil hasil data
        $lsm = $query->get();

        return view('lsm.index', compact('lsm'));
    }

    public function create()
    {
        return view('lsm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'jumlah_sasaran' => 'required|integer|min:0',
            'tanggal_pelaksanaan' => 'nullable|date',

            'terekam' => 'nullable|integer|min:0',
            'gagal_rekam' => 'nullable|integer|min:0',
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

        lsm::create([
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'jumlah_sasaran' => $request->jumlah_sasaran,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,

            'terekam' => $request->terekam ?? 0,
            'gagal_rekam' => $request->gagal_rekam ?? 0,
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

    public function edit($id)
    {
        $lsm = lsm::findOrFail($id);

        // Jika status sudah selesai, tidak boleh diedit
        if ($lsm->status_progress === 'selesai') {
            return redirect()
                ->route('lsm.index')
                ->with('error', 'Akses ditolak! Data yang sudah selesai telah dikunci.');
        }

        return view('lsm.edit', compact('lsm'));
    }

    public function update(Request $request, $id)
    {
        $lsm = lsm::findOrFail($id);

        // Jika status sudah selesai, tidak boleh diubah
        if ($lsm->status_progress === 'selesai') {
            return redirect()
                ->route('lsm.index')
                ->with('error', 'Perubahan ditolak! Data ini sudah berstatus selesai.');
        }

        $request->validate([
            'kecamatan' => 'required|string|max:255',
            'kelurahan' => 'required|string|max:255',
            'jumlah_sasaran' => 'required|integer|min:0',
            'tanggal_pelaksanaan' => 'nullable|date',

            'terekam' => 'nullable|integer|min:0',
            'gagal_rekam' => 'nullable|integer|min:0',
            'sudah_memiliki_ktp' => 'nullable|integer|min:0',
            'tidak_hadir' => 'nullable|integer|min:0',

            'foto_1' => 'nullable|image|mimes:jpeg,png,jpg',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $data = [
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'jumlah_sasaran' => $request->jumlah_sasaran,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,

            'terekam' => $request->terekam ?? 0,
            'gagal_rekam' => $request->gagal_rekam ?? 0,
            'sudah_memiliki_ktp' => $request->sudah_memiliki_ktp ?? 0,
            'tidak_hadir' => $request->tidak_hadir ?? 0,
        ];

        // Jika upload foto 1 baru
        if ($request->hasFile('foto_1')) {

            if ($lsm->foto_1) {
                Storage::disk('public')->delete($lsm->foto_1);
            }

            $data['foto_1'] = $request->file('foto_1')
                ->store('dokumentasi_lsm', 'public');
        }

        // Jika upload foto 2 baru
        if ($request->hasFile('foto_2')) {

            if ($lsm->foto_2) {
                Storage::disk('public')->delete($lsm->foto_2);
            }

            $data['foto_2'] = $request->file('foto_2')
                ->store('dokumentasi_lsm', 'public');
        }

        $lsm->update($data);

        return redirect()
            ->route('lsm.index')
            ->with('success', 'Data LSM berhasil diperbarui!');
    }

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

        $centerStyle = ['alignment' => Jc::CENTER];

        $section->addText(
            "Pelayanan LSM",
            ['bold' => true, 'size' => 14],
            $centerStyle
        );

        $section->addText(
            "Kelurahan " . $lsm->kelurahan .
            " Kecamatan " . str_replace('_', ' ', $lsm->kecamatan),
            ['size' => 11],
            $centerStyle
        );

        $section->addTextBreak(1);

        if ($lsm->foto_1 && Storage::disk('public')->exists($lsm->foto_1)) {
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

        if ($lsm->foto_2 && Storage::disk('public')->exists($lsm->foto_2)) {
            $section->addImage(
                public_path('storage/' . $lsm->foto_2),
                [
                    'width' => 400,
                    'height' => 240,
                    'alignment' => Jc::CENTER
                ]
            );
        }

        $bulanTahun = $lsm->tanggal_pelaksanaan
            ? Carbon::parse($lsm->tanggal_pelaksanaan)->translatedFormat('F Y')
            : 'Tanpa Tanggal';

        $fileName = $bulanTahun .
            " - " .
            $lsm->kelurahan .
            " (" .
            $lsm->kecamatan .
            " - LSM).docx";

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');

        $tempFile = tempnam(sys_get_temp_dir(), 'phpword_');

        $objWriter->save($tempFile);

        return response()
            ->download($tempFile, $fileName)
            ->deleteFileAfterSend(true);
    }

    public function destroy($id)
    {
        $lsm = lsm::findOrFail($id);

        // Hapus foto dari storage jika ada
        if ($lsm->foto_1) {
            Storage::disk('public')->delete($lsm->foto_1);
        }

        if ($lsm->foto_2) {
            Storage::disk('public')->delete($lsm->foto_2);
        }

        $lsm->delete();

        return redirect()
            ->route('lsm.index')
            ->with('success', 'Data LSM berhasil dihapus.');
    }
}