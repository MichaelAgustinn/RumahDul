<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WebContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // --- MANAJEMEN DOSEN --- //
    // 1. Update fungsi Index (Hapus pencarian email)
    public function indexUsers(Request $request)
    {
        $query = User::latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nidn', 'like', '%' . $search . '%');
            });
        }

        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'nidn' => 'required|string|max:20|unique:users,nidn,' . $user->id,
            'name' => 'required|string|max:255',
        ]);

        $user->update([
            'nidn' => $request->nidn,
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nidn' => 'required|string|max:20|unique:users',
            'name' => 'required|string|max:255',
        ]);

        User::create([
            'nidn' => $request->nidn,
            'name' => $request->name,
            'password' => Hash::make($request->nidn),
            'role' => 'dosen',
        ]);

        return redirect()->back()->with('success', 'Akun dosen berhasil ditambahkan!');
    }

    public function resetPassword(User $user)
    {
        if (!$user->nidn) {
            return redirect()->back()->withErrors('Gagal reset: Akun ini tidak memiliki NIDN yang terdaftar.');
        }

        $user->update([
            'password' => Hash::make($user->nidn)
        ]);

        return redirect()->back()->with('success', "Password untuk {$user->name} berhasil direset kembali ke NIDN.");
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->withErrors('Anda tidak bisa mengubah role Anda sendiri.');
        }

        $request->validate([
            'role' => 'required|in:admin,dosen',
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', "Hak akses {$user->name} berhasil diubah menjadi " . strtoupper($request->role) . ".");
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->withErrors('Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }

    // --- PENGATURAN KONTEN WEB --- //

    public function editContent()
    {
        // Ambil data pertama, jika belum ada buat instance kosong
        $content = WebContent::first() ?? new WebContent();
        return view('admin.web-content.edit', compact('content'));
    }

    public function updateContent(Request $request)
    {
        $request->validate([
            'site_title' => 'required|string|max:255',
            'footer_address' => 'required|string',
            'footer_phone' => 'required|string|max:50',
            'footer_email' => 'required|email|max:255',
        ]);

        $content = WebContent::first();

        if ($content) {
            $content->update($request->all());
        } else {
            WebContent::create($request->all());
        }

        return redirect()->back()->with('success', 'Informasi website berhasil diperbarui!');
    }
}
