<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModulLog;
use App\Models\WebContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // Tambahkan ini untuk mengelola file di public
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        $query = Module::query();

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('mata_kuliah')) {
            $query->where('mata_kuliah', $request->mata_kuliah);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $modules = $query->with('user')->latest()->paginate(10);
        $webContent = WebContent::first();

        return view('modules.index', compact('modules', 'webContent'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Dasar
        $rules = [
            'judul' => 'required|string|max:255',
            'mata_kuliah' => 'required|string|max:255',
            'jenis' => 'required|in:modul praktikum,modul ajar',
            'file_pdf' => 'required|mimes:pdf|max:15360',
        ];

        // 2. Jika Admin, wajibkan validasi pilihan dosen
        if (Auth::user()->role === 'admin') {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        // 3. Proses Penamaan & Upload File ke folder Public
        $file = $request->file('file_pdf');
        $safeFileName = Str::slug($request->jenis . '-' . $request->mata_kuliah);
        $fileName = $safeFileName . '-' . time() . '.pdf';

        // Pindahkan file langsung ke folder public/uploads/modul_pdfs
        $file->move(public_path('uploads/modul_pdfs'), $fileName);

        // Simpan path relatifnya untuk database
        $pdfPath = 'uploads/modul_pdfs/' . $fileName;

        // 4. Penentuan Pemilik Modul
        $pemilikId = Auth::user()->role === 'admin' ? $request->user_id : Auth::id();

        // 5. Simpan ke Database
        Module::create([
            'user_id' => $pemilikId,
            'judul' => $request->judul,
            'mata_kuliah' => $request->mata_kuliah,
            'jenis' => $request->jenis,
            'file_path' => $pdfPath,
        ]);

        return redirect()->back()->with('success', 'Modul berhasil diunggah!');
    }

    public function edit(Module $module)
    {
        if (Auth::user()->role !== 'admin' && $module->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit modul ini.');
        }

        $dosens = Auth::user()->role === 'admin'
            ? \App\Models\User::where('role', 'dosen')->orderBy('name')->get()
            : collect();

        return view('dashboard.edit', compact('module', 'dosens'));
    }

    public function update(Request $request, Module $module)
    {
        // Pengecekan Hak Akses
        if (Auth::user()->role !== 'admin' && $module->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit modul ini.');
        }

        $rules = [
            'judul' => 'required|string|max:255',
            'mata_kuliah' => 'required|string|max:255',
            'jenis' => 'required|in:modul praktikum,modul ajar',
            'file_pdf' => 'nullable|mimes:pdf|max:15360',
        ];

        if (Auth::user()->role === 'admin') {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        // Update data teks
        $module->judul = $request->judul;
        $module->mata_kuliah = $request->mata_kuliah;
        $module->jenis = $request->jenis;

        if (Auth::user()->role === 'admin') {
            $module->user_id = $request->user_id;
        }

        // Jika user mengupload PDF baru, hapus yang lama di public dan simpan yang baru
        if ($request->hasFile('file_pdf')) {
            // Hapus PDF lama secara fisik
            if (File::exists(public_path($module->file_path))) {
                File::delete(public_path($module->file_path));
            }

            // Upload PDF baru
            $file = $request->file('file_pdf');
            $safeFileName = Str::slug($request->jenis . '-' . $request->mata_kuliah);
            $fileName = $safeFileName . '-' . time() . '.pdf';

            // Pindahkan file ke folder public/uploads/modul_pdfs
            $file->move(public_path('uploads/modul_pdfs'), $fileName);

            // Perbarui path di database
            $module->file_path = 'uploads/modul_pdfs/' . $fileName;
        }

        $module->save();

        return redirect()->route('dashboard')->with('success', 'Data modul berhasil diperbarui!');
    }

    public function destroy(Module $module)
    {
        if (Auth::user()->role !== 'admin' && $module->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus modul ini.');
        }

        // Hapus file fisik dari folder public
        if (File::exists(public_path($module->file_path))) {
            File::delete(public_path($module->file_path));
        }

        // Hapus data dari database
        $module->delete();

        return redirect()->back()->with('success', 'Modul berhasil dihapus.');
    }

    public function viewPdf(Module $module)
    {
        $module->increment('views_count');
        ModulLog::create([
            'modul_id' => $module->id,
            'type' => 'view'
        ]);
        return view('modules.show', compact('module'));
    }

    public function downloadPdf(Module $module)
    {
        $module->increment('downloads_count');
        ModulLog::create([
            'modul_id' => $module->id,
            'type' => 'download'
        ]);

        // Arahkan proses download langsung ke folder public
        return response()->download(public_path($module->file_path), $module->judul . '.pdf');
    }
}
