<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Menampilkan halaman update password.
     */
    public function edit()
    {
        return view('password.edit');
    }

    /**
     * Memperbarui password user.
     */
    public function update(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Update password user yang sedang login
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect kembali dengan pesan sukses
        return back()->with('status', 'Password berhasil diperbarui!');
    }
}
