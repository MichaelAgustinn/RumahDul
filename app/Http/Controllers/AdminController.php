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
    public function indexUsers()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nidn' => 'required|string|max:20|unique:users', // Validasi NIDN
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'nidn' => $request->nidn,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dosen',
        ]);

        return redirect()->back()->with('success', 'Akun dosen berhasil ditambahkan!');
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
