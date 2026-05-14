<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Menampilkan halaman Manajemen User beserta datanya.
     */
    public function index()
    {
        // Mengambil semua user, diurutkan dari yang terbaru
        $users = User::latest()->get();

        return view('user-management', compact('users'));
    }

    /**
     * Menyimpan user/staf baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => ['required', Rule::in(['owner', 'manager', 'staff', 'auditor'])],
        ], [
            // Kustomisasi pesan error agar lebih ramah (opsional)
            'email.unique' => 'Email ini sudah terdaftar di sistem kami.',
            'password.min' => 'Password minimal harus 8 karakter untuk keamanan.'
        ]);

        // 2. Simpan ke Database
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role'     => $request->role,
        ]);

        // 3. Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Akun staf baru berhasil ditambahkan!');
    }

    /**
     * Mengupdate role dari user yang sudah ada.
     */
    public function update(Request $request, User $user)
    {
        // Validasi role yang dikirim
        $request->validate([
            'role' => ['required', Rule::in(['owner', 'manager', 'staff', 'auditor'])],
        ]);

        // Cegah super admin/owner terakhir menghapus role-nya sendiri (Keamanan ekstra)
        if ($user->id === auth()->id() && $user->role === 'owner' && $request->role !== 'owner') {
            $ownerCount = User::where('role', 'owner')->count();
            if ($ownerCount <= 1) {
                return redirect()->back()->with('error', 'Gagal! Harus ada minimal 1 Owner di dalam sistem.');
            }
        }

        // Update role
        $user->update([
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'Role pengguna berhasil diperbarui!');
    }

    /**
     * (Bonus) Menghapus User
     */
    public function destroy(User $user)
    {
        // Cegah user menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
