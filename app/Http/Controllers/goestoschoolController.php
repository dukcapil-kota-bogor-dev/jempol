<?php

namespace App\Http\Controllers;

use App\Models\GoesToSchool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use Carbon\Carbon;

class GoesToSchoolController extends Controller
{
    /**
     * Menampilkan daftar Goes To School dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = GoesToSchool::orderByRaw(
            "CASE WHEN status_progress = 'proses' THEN 0 ELSE 1 END"
        )
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                    ->orWhere('rencana_pelaksanaan', 'like', "%{$search}%")
                    ->orWhere('kecamatan', 'like', "%{$search}%")
                    ->orWhere('kelurahan', 'like', "%{$search}%")
                    ->orWhere('tanggal_pelaksanaan', 'like', "%{$search}%");
            });
        }

        $goesToSchools = $query->get();

        return view('goes_to_school.index', compact('goesToSchools'));
    }

    /**
     * Menampilkan form tambah data.
     */
    public function create()
    {
        return view('goes_to_school.create');
    }

    /**
     * Menyimpan data Goes To School baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'rencana_pelaksanaan' => 'nullable|string|max:255',
            'jumlah_target' => 'required|integer|min:0',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'tanggal_pelaksanaan' => 'nullable|date',
            'terekam' => 'nullable|integer|min:0',
            'terekam_gagal' => 'nullable|integer|min:0',
            'kurang_dari_16_tahun' => 'nullable|integer|min:0',
            'sudah_punya' => 'nullable|integer|min:0',
            'tidak_hadir' => 'nullable|integer|min:0',
            'aktivasi_ikd' => 'nullable|integer|min:0',
            'foto_1' => 'nullable|image|mimes:jpeg,png,jpg',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        $data = [
            'nama_sekolah' => $validated['nama_sekolah'],
            'rencana_pelaksanaan' => $validated['rencana_pelaksanaan'] ?? null,
            'jumlah_target' => $validated['jumlah_target'],
            'kecamatan' => $validated['kecamatan'] ?? null,
            'kelurahan' => $validated['kelurahan'] ?? null,
            'tanggal_pelaksanaan' => $validated['tanggal_pelaksanaan'] ?? null,
            'terekam' => $validated['terekam'] ?? 0,
            'terekam_gagal' => $validated['terekam_gagal'] ?? 0,
            'kurang_dari_16_tahun' => $validated['kurang_dari_16_tahun'] ?? 0,
            'sudah_punya' => $validated['sudah_punya'] ?? 0,
            'tidak_hadir' => $validated['tidak_hadir'] ?? 0,
            'aktivasi_ikd' => $validated['aktivasi_ikd'] ?? 0,
            'status_progress' => 'proses',
        ];

        if ($request->hasFile('foto_1')) {
            $data['foto_1'] = $request->file('foto_1')
                ->store('dokumentasi_goes_to_school', 'public');
        }

        if ($request->hasFile('foto_2')) {
            $data['foto_2'] = $request->file('foto_2')
                ->store('dokumentasi_goes_to_school', 'public');
        }

        GoesToSchool::create($data);

        return redirect()
            ->route('goes_to_school.index')
            ->with('success', 'Data Goes To School berhasil diajukan!');
    }

    /**
     * Menampilkan form edit data.
     */
    public function edit($id)
    {
        $goesToSchool = GoesToSchool::findOrFail($id);

        if ($goesToSchool->status_progress === 'selesai') {
            return redirect()
                ->route('goes_to_school.index')
                ->with('error', 'Akses ditolak! Data yang sudah selesai telah dikunci.');
        }

        return view('goes_to_school.edit', compact('goesToSchool'));
    }

    /**
     * Memperbarui dan menyelesaikan data Goes To School.
     */
    public function update(Request $request, $id)
    {
        $goesToSchool = GoesToSchool::findOrFail($id);

        if ($goesToSchool->status_progress === 'selesai') {
            return redirect()
                ->route('goes_to_school.index')
                ->with('error', 'Perubahan ditolak! Data ini sudah berstatus selesai.');
        }

        $validated = $request->validate([
            'tanggal_pelaksanaan' => 'required|date',
            'rencana_pelaksanaan' => 'nullable|string|max:255',
            'kecamatan' => 'sometimes|required|string|max:255',
            'kelurahan' => 'sometimes|required|string|max:255',
            'terekam' => 'sometimes|nullable|integer|min:0',
            'terekam_gagal' => 'sometimes|nullable|integer|min:0',
            'kurang_dari_16_tahun' => 'sometimes|nullable|integer|min:0',
            'sudah_punya' => 'sometimes|nullable|integer|min:0',
            'tidak_hadir' => 'sometimes|nullable|integer|min:0',
            'aktivasi_ikd' => 'sometimes|nullable|integer|min:0',
            'foto_1' => 'nullable|image|mimes:jpeg,png,jpg',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg',
        ]);

        // Gunakan nilai baru jika dikirim; jika tidak, pertahankan nilai lama.
        $data = [
            'rencana_pelaksanaan' => $validated['rencana_pelaksanaan']
                ?? $goesToSchool->rencana_pelaksanaan,

            'tanggal_pelaksanaan' => $validated['tanggal_pelaksanaan'],

            'kecamatan' => $validated['kecamatan']
                ?? $goesToSchool->kecamatan,

            'kelurahan' => $validated['kelurahan']
                ?? $goesToSchool->kelurahan,

            'terekam' => $validated['terekam']
                ?? $goesToSchool->terekam,

            'terekam_gagal' => $validated['terekam_gagal']
                ?? $goesToSchool->terekam_gagal,

            'kurang_dari_16_tahun' => $validated['kurang_dari_16_tahun']
                ?? $goesToSchool->kurang_dari_16_tahun,

            'sudah_punya' => $validated['sudah_punya']
                ?? $goesToSchool->sudah_punya,

            'tidak_hadir' => $validated['tidak_hadir']
                ?? $goesToSchool->tidak_hadir,

            'aktivasi_ikd' => $validated['aktivasi_ikd']
                ?? $goesToSchool->aktivasi_ikd,

            'status_progress' => 'selesai',
        ];

        if ($request->hasFile('foto_1')) {
            if ($goesToSchool->foto_1) {
                Storage::disk('public')->delete($goesToSchool->foto_1);
            }

            $data['foto_1'] = $request->file('foto_1')
                ->store('dokumentasi_goes_to_school', 'public');
        }

        if ($request->hasFile('foto_2')) {
            if ($goesToSchool->foto_2) {
                Storage::disk('public')->delete($goesToSchool->foto_2);
            }

            $data['foto_2'] = $request->file('foto_2')
                ->store('dokumentasi_goes_to_school', 'public');
        }

        $goesToSchool->update($data);

        return redirect()
            ->route('goes_to_school.index')
            ->with('success', 'Data Goes To School berhasil diselesaikan!');
    }

    /**
     * Download laporan Goes To School dalam bentuk Word.
     */
    public function downloadDocx($id)
    {
        $g = GoesToSchool::findOrFail($id);

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
            'Kegiatan Goes To School',
            ['bold' => true, 'size' => 14],
            $centerStyle
        );

        $section->addText(
            strtoupper($g->nama_sekolah),
            ['bold' => true, 'size' => 12],
            $centerStyle
        );

        $section->addText(
            'Rencana Pelaksanaan: ' . ($g->rencana_pelaksanaan ?: '-'),
            ['size' => 11],
            $centerStyle
        );

        $section->addText(
            'Kelurahan ' . ($g->kelurahan ?: '-') .
            ' Kecamatan ' . str_replace('_', ' ', $g->kecamatan ?: '-'),
            ['size' => 11],
            $centerStyle
        );

        $section->addTextBreak(1);

        if ($g->foto_1 && Storage::disk('public')->exists($g->foto_1)) {
            $section->addImage(
                Storage::disk('public')->path($g->foto_1),
                ['width' => 400, 'height' => 240]
            );
            $section->addTextBreak(1);
        }

        if ($g->foto_2 && Storage::disk('public')->exists($g->foto_2)) {
            $section->addImage(
                Storage::disk('public')->path($g->foto_2),
                ['width' => 400, 'height' => 240]
            );
        }

        $section->addTextBreak(1);

        $section->addText('Hasil Kegiatan', ['bold' => true]);
        $section->addText('Jumlah Target: ' . $g->jumlah_target);
        $section->addText('Terekam: ' . $g->terekam);
        $section->addText('Gagal Rekam: ' . $g->terekam_gagal);
        $section->addText('< 16 Tahun: ' . $g->kurang_dari_16_tahun);
        $section->addText('Sudah Punya KTP: ' . $g->sudah_punya);
        $section->addText('Tidak Hadir: ' . $g->tidak_hadir);
        $section->addText('Aktivasi IKD: ' . $g->aktivasi_ikd);

        $bulanTahun = $g->tanggal_pelaksanaan
            ? Carbon::parse($g->tanggal_pelaksanaan)->translatedFormat('F Y')
            : 'Tanpa Tanggal';

        $fileName = $bulanTahun . ' - ' . $g->nama_sekolah . ' (Goes To School).docx';

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $tempFile = tempnam(sys_get_temp_dir(), 'phpword_');

        $objWriter->save($tempFile);

        return response()
            ->download($tempFile, $fileName)
            ->deleteFileAfterSend(true);
    }

    /**
     * Menghapus data Goes To School.
     */
    public function destroy($id)
    {
        $goesToSchool = GoesToSchool::findOrFail($id);

        if ($goesToSchool->foto_1) {
            Storage::disk('public')->delete($goesToSchool->foto_1);
        }

        if ($goesToSchool->foto_2) {
            Storage::disk('public')->delete($goesToSchool->foto_2);
        }

        $goesToSchool->delete();

        return redirect()
            ->route('goes_to_school.index')
            ->with('success', 'Data Goes To School berhasil dihapus.');
    }
}