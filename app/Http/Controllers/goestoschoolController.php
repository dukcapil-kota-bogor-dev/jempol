<?php

namespace App\Http\Controllers;

use App\Models\goestoschool;
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
        // Ambil input pencarian dari request
        $search = $request->query('search');

        // Query dasar dengan pengurutan
        // Status 'proses' selalu di atas
        $query = GoesToSchool::orderByRaw(
            "CASE WHEN status_progress = 'proses' THEN 0 ELSE 1 END"
        )
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->orderBy('created_at', 'desc');

        // Jika ada input pencarian, tambahkan filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                  ->orWhere('kecamatan', 'like', "%{$search}%")
                  ->orWhere('kelurahan', 'like', "%{$search}%")
                  ->orWhere('tanggal_pelaksanaan', 'like', "%{$search}%");
            });
        }

        // Ambil hasil data
        $goesToSchools = $query->get();

        return view('goes_to_school.index', compact('goesToSchools'));
    }


    public function create()
    {
        return view('goes_to_school.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jadwal_pelaksanaan' => 'nullable|string|max:255',
            'jumlah_target' => 'required|integer|min:0',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'tanggal_pelaksanaan' => 'nullable|date',

            'terekam' => 'nullable|integer|min:0',
            'terekam_gagal' => 'nullable|integer|min:0',
            'kurang_dari_16_tahun' => 'nullable|integer|min:0',
            'sudah_punya' => 'nullable|integer|min:0',
            'tidak_hadir' => 'nullable|integer|min:0',

            'foto_1' => 'nullable|image|mimes:jpeg,png,jpg',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg',

            // Status aktivasi IKD
            'status_ikd' => 'required|in:sudah_aktivasi,belum_aktivasi',
        ]);

        // Simpan foto kegiatan
        $foto1Path = null;
        $foto2Path = null;

        if ($request->hasFile('foto_1')) {
            $foto1Path = $request->file('foto_1')
                ->store('dokumentasi_goes_to_school', 'public');
        }

        if ($request->hasFile('foto_2')) {
            $foto2Path = $request->file('foto_2')
                ->store('dokumentasi_goes_to_school', 'public');
        }

        GoesToSchool::create([
            'nama_sekolah' => $request->nama_sekolah,
            'jadwal_pelaksanaan' => $request->jadwal_pelaksanaan,
            'jumlah_target' => $request->jumlah_target,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,

            'terekam' => $request->terekam ?? 0,
            'terekam_gagal' => $request->terekam_gagal ?? 0,
            'kurang_dari_16_tahun' => $request->kurang_dari_16_tahun ?? 0,
            'sudah_punya' => $request->sudah_punya ?? 0,
            'tidak_hadir' => $request->tidak_hadir ?? 0,

            'foto_1' => $foto1Path,
            'foto_2' => $foto2Path,

            // Status IKD
            'status_ikd' => $request->status_ikd,

            // Status awal
            'status_progress' => 'proses',
        ]);

        return redirect()->route('goes_to_school.index')->with('success','Data Goes To School berhasil diajukan!');
    }


    public function edit($id)
    {
        $goesToSchool = GoesToSchool::findOrFail($id);

        if ($goesToSchool->status_progress === 'selesai') {return redirect()->route('goes_to_school.index')->with('error','Akses ditolak! Data yang sudah selesai telah dikunci.');
        }

        return view('goes_to_school.edit', compact('goesToSchool'));
    }


    public function update(Request $request, $id)
    {
        $goesToSchool = GoesToSchool::findOrFail($id);

        if ($goesToSchool->status_progress === 'selesai') {
            return redirect()->route('goes_to_school.index')->with('error','Perubahan ditolak! Data ini sudah berstatus selesai.');
        }

        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jadwal_pelaksanaan' => 'nullable|string|max:255',
            'jumlah_target' => 'required|integer|min:0',
            'kecamatan' => 'nullable|string|max:255',
            'kelurahan' => 'nullable|string|max:255',
            'tanggal_pelaksanaan' => 'nullable|date',

            'terekam' => 'nullable|integer|min:0',
            'terekam_gagal' => 'nullable|integer|min:0',
            'kurang_dari_16_tahun' => 'nullable|integer|min:0',
            'sudah_punya' => 'nullable|integer|min:0',
            'tidak_hadir' => 'nullable|integer|min:0',

            'foto_1' => 'nullable|image|mimes:jpeg,png,jpg',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg',

            'status_ikd' => 'required|in:sudah_aktivasi,belum_aktivasi',
        ]);

        $data = [
            'nama_sekolah' => $request->nama_sekolah,
            'jadwal_pelaksanaan' => $request->jadwal_pelaksanaan,
            'jumlah_target' => $request->jumlah_target,

            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,

            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'terekam' => $request->terekam ?? 0,
            'terekam_gagal' => $request->terekam_gagal ?? 0,
            'kurang_dari_16_tahun' => $request->kurang_dari_16_tahun ?? 0,
            'sudah_punya' => $request->sudah_punya ?? 0,
            'tidak_hadir' => $request->tidak_hadir ?? 0,
            'status_ikd' => $request->status_ikd,
        ];

        if ($request->hasFile('foto_1')) {

            if ($goesToSchool->foto_1) {Storage::disk('public')->delete($goesToSchool->foto_1);
            }

            $data['foto_1'] = $request->file('foto_1')->store('dokumentasi_goes_to_school', 'public');
        }

        // Jika upload foto 2 baru
        if ($request->hasFile('foto_2')) {

            if ($goesToSchool->foto_2) {Storage::disk('public')->delete($goesToSchool->foto_2);
            }

            $data['foto_2'] = $request->file('foto_2')->store('dokumentasi_goes_to_school', 'public');
        }

        $goesToSchool->update($data);

        return redirect()->route('goes_to_school.index')->with('success','Data Goes To School berhasil diperbarui!');
    }


    public function downloadDocx($id)
    {
        $g = GoesToSchool::findOrFail($id);

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection(['marginTop' => 1200,'marginBottom' => 1200,'marginLeft' => 1200,'marginRight' => 1200,]);

        $centerStyle = ['alignment' => Jc::CENTER];
        $namaSekolah = strtoupper($g->nama_sekolah);
        $section->addText("Kegiatan Goes To School",['bold' => true, 'size' => 14],$centerStyle);

        $section->addText($namaSekolah,['bold' => true, 'size' => 12],$centerStyle);
        $section->addText("Kelurahan " . $g->kelurahan . " Kecamatan " . str_replace('_', ' ', $g->kecamatan),['size' => 11],$centerStyle);
        $section->addTextBreak(1);

        if ($g->foto_1 &&Storage::disk('public')->exists($g->foto_1)
        ) {
            $section->addImage(public_path('storage/' . $g->foto_1), ['width' => 400,'height' => 240,'alignment' => Jc::CENTER]);
            $section->addTextBreak(1);
        }

        if ($g->foto_2 &&Storage::disk('public')->exists($g->foto_2)) {
            $section->addImage(public_path('storage/' . $g->foto_2),['width' => 400,'height' => 240,'alignment' => Jc::CENTER]);
        }

        if ($g->aktivasi_IKD &&Storage::disk('public')->exists($g->aktivasi_IKD)) {
            $section->addImage(public_path('storage/' . $g->aktivasi_IKD),['width' => 400,'height' => 240,'alignment' => Jc::CENTER]);
        }

        $bulanTahun = $g->tanggal_pelaksanaan? Carbon::parse($g->tanggal_pelaksanaan)->translatedFormat('F Y'): 'Tanpa Tanggal';
        $fileName = $bulanTahun . " - " . $g->nama_sekolah ." (Goes To School).docx";

        $objWriter = IOFactory::createWriter($phpWord,'Word2007');
        $tempFile = tempnam(sys_get_temp_dir(),'phpword_');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }


    public function destroy($id)
    {
        $goesToSchool = GoesToSchool::findOrFail($id);

        // Hapus foto dari storage jika ada
        if ($goesToSchool->foto_1) {
            Storage::disk('public')->delete($goesToSchool->foto_1);
        }
        if ($goesToSchool->foto_2) {
            Storage::disk('public')->delete($goesToSchool->foto_2);
        }

        $goesToSchool->delete();

        return redirect()->route('goes_to_school.index')->with('success','Data Goes To School berhasil dihapus.');
    }
}