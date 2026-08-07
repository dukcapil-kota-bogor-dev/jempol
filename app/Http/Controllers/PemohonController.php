<?php

namespace App\Http\Controllers;

use App\Models\Pemohon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\SimpleType\Jc;
use Carbon\Carbon;

class PemohonController extends Controller
{
    /**
     * Menampilkan daftar pemohon dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        // Ambil input pencarian dari request
        $search = $request->query('search');

        // Query dasar dengan pengurutan (Status 'proses' selalu di atas)
        $query = Pemohon::orderByRaw("CASE WHEN status_progress = 'proses' THEN 0 ELSE 1 END")
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->orderBy('created_at', 'desc');

        // Jika ada input pencarian, tambahkan filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('tanggal_permohonan', 'like', "%{$search}%")
                  ->orWhere('tanggal_pelaksanaan', 'like', "%{$search}%");
            });
        }

        // Ambil hasil data
        $pemohons = $query->get();

        return view('pemohon.index', compact('pemohons'));
    }

    public function create()
    {
        return view('pemohon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_permohonan' => 'required|date',
            'nik' => 'nullable|digits:16|unique:pemohons,nik',
            'nama_lengkap' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'keterangan' => 'nullable',
        ]);

        Pemohon::create([
            'jenis_input' => $request->jenis_input,
            'no_pemohon' => $request->no_pemohon,
            'tanggal_permohonan' => $request->tanggal_permohonan,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'kecamatan' => $request->kecamatan,
            'kelurahan' => $request->kelurahan,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'status_pemohon' => $request->status_pemohon,
            'keterangan' => $request->keterangan,
            'status_progress' => 'proses', 
        ]);

        return redirect()->route('pemohon.index')->with('success', 'Data pemohon berhasil diajukan!');
    }

    public function edit($id)
    {
        $pemohon = Pemohon::findOrFail($id);

        // PROTEKSI: Jika status sudah selesai, dilarang edit profil
        if ($pemohon->status_progress === 'selesai') {
            return redirect()->route('pemohon.index')
                ->with('error', 'Akses ditolak! Data yang sudah selesai telah dikunci.');
        }

        return view('pemohon.edit', compact('pemohon'));
    }

    public function update(Request $request, $id)
    {
        $pemohon = Pemohon::findOrFail($id);

        // PROTEKSI: Jika status sudah selesai, dilarang melakukan update apapun
        if ($pemohon->status_progress === 'selesai') {
            return redirect()->route('pemohon.index')
                ->with('error', 'Perubahan ditolak! Data ini sudah berstatus selesai.');
        }

        // LOGIKA A: Jika request datang dari FORM EDIT PROFIL
        if ($request->has('nama_lengkap')) {
            $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'nik' => 'nullable|digits:16|unique:pemohons,nik,' . $id,
                'kecamatan' => 'required',
                'kelurahan' => 'required',
                'rt' => 'nullable|string',
                'rw' => 'nullable|string',
                'tanggal_permohonan' => 'required|date',
            ]);

            $pemohon->update([
                'nama_lengkap' => $request->nama_lengkap,
                'nik' => $request->nik,
                'status_pemohon' => $request->status_pemohon,
                'kecamatan' => $request->kecamatan,
                'kelurahan' => $request->kelurahan,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'tanggal_permohonan' => $request->tanggal_permohonan,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('pemohon.index')->with('success', 'Informasi profil warga berhasil diperbarui!');
        }

        // LOGIKA B: Jika request datang dari MODAL SELESAI PEREKAMAN
        $request->validate([
            'tanggal_pelaksanaan' => 'required|date',
            'lokasi_perekaman' => 'required|string',
            'lokasi_perekaman_detail' => 'nullable|string|max:255',
            'foto_1' => 'required|image|mimes:jpeg,png,jpg',
            'foto_2' => 'required|image|mimes:jpeg,png,jpg',
            'keterangan' => 'nullable|string',
        ]);

        $lokasiFinal = $request->lokasi_perekaman;
        if ($request->lokasi_perekaman === 'Luar Wilayah' && $request->filled('lokasi_perekaman_detail')) {
            $lokasiFinal = $request->lokasi_perekaman_detail;
        }

        // Simpan foto baru
        $foto1Path = $request->file('foto_1')->store('dokumentasi', 'public');
        $foto2Path = $request->file('foto_2')->store('dokumentasi', 'public');

        $pemohon->update([
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'lokasi_perekaman'    => $lokasiFinal,
            'foto_1'              => $foto1Path,
            'foto_2'              => $foto2Path,
            'keterangan'          => $request->keterangan,
            'status_progress'     => 'selesai', 
        ]);

        return redirect()->route('pemohon.index')->with('success', 'Perekaman telah diselesaikan!');
    }

    public function downloadDocx($id)
    {
        $p = Pemohon::findOrFail($id);

        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Arial');
        $phpWord->setDefaultFontSize(11);

        $section = $phpWord->addSection([
            'marginTop' => 1200, 'marginBottom' => 1200, 'marginLeft' => 1200, 'marginRight' => 1200,
        ]);

        $centerStyle = ['alignment' => Jc::CENTER];

        $statusRaw = strtolower($p->status_pemohon);
        $statusFormatted = ($statusRaw === 'odgj') ? 'ODGJ' : ucwords($statusRaw);
        $namaCaps = strtoupper($p->nama_lengkap);

        $section->addText("Perekaman KTP " . $statusFormatted . " a.n. " . $namaCaps, ['bold' => true, 'size' => 12], $centerStyle);
        $section->addText("Kelurahan " . $p->kelurahan . " Kecamatan " . str_replace('_', ' ', $p->kecamatan), ['size' => 11], $centerStyle);
        $section->addTextBreak(1);

        if ($p->foto_1 && Storage::disk('public')->exists($p->foto_1)) {
            $section->addImage(public_path('storage/' . $p->foto_1), ['width' => 400, 'height' => 240, 'alignment' => Jc::CENTER]);
            $section->addTextBreak(1);
        }

        if ($p->foto_2 && Storage::disk('public')->exists($p->foto_2)) {
            $section->addImage(public_path('storage/' . $p->foto_2), ['width' => 400, 'height' => 240, 'alignment' => Jc::CENTER]);
        }

        $bulanTahun = Carbon::parse($p->tanggal_pelaksanaan)->translatedFormat('F Y');
        $fileName = $bulanTahun . " - " . $p->nama_lengkap . " (" . $p->kelurahan . ").docx";

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $tempFile = tempnam(sys_get_temp_dir(), 'phpword_');
        $objWriter->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function destroy($id)
    {
        $pemohon = Pemohon::findOrFail($id);
        
        // Hapus foto dari storage jika ada
        if ($pemohon->foto_1) Storage::disk('public')->delete($pemohon->foto_1);
        if ($pemohon->foto_2) Storage::disk('public')->delete($pemohon->foto_2);
        
        $pemohon->delete();

        return redirect()->route('pemohon.index')->with('success', 'Data pemohon berhasil dihapus.');
    }
}