<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai; // Pastikan ini ada
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Untuk Transaction
use Illuminate\Support\Facades\Auth;

class UserController extends Controller // <--- INI WAJIB ADA!
{ 
    // { <--- KURUNG KURAWAL PEMBUKA INI WAJIB ADA

    /**
     * Tampilkan daftar user.
     */
    public function index(Request $request)
    {
        $users = User::with('roles')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%")
                      ->orWhere('email', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('pages.admin.users.index', compact('users'));
    }

    /**
     * Tampilkan form tambah user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('pages.admin.users.create', compact('roles'));
    }

    /**
     * Simpan user baru + Data Pegawai.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|exists:roles,name',
            // Data Pegawai (Opsional tapi disarankan diisi)
            'nip'      => 'nullable|unique:pegawai,nip',
            'no_hp'    => 'nullable|numeric',
        ]);

        // 2. Transaksi Database
        DB::transaction(function () use ($request) {
            
            // A. Simpan User
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => true,
            ]);

            $user->assignRole($request->role);

            // B. Simpan Pegawai (Jika bukan murid)
            if ($request->role !== 'murid') {
                Pegawai::create([
                    'user_id' => $user->id,
                    'nip'     => $request->nip,
                    'nama_lengkap' => $request->name, // Mapping nama user ke nama pegawai
                    'no_hp'   => $request->no_hp,
                    // Isi default untuk kolom wajib lain agar tidak error
                    'nik_ktp' => $request->nip ?? time(), // Dummy NIK jika kosong
                ]);
            }
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit user.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('pages.admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update data user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|exists:roles,name',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        if (Auth::id() == $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete(); // Data pegawai otomatis terhapus jika settingan database cascade
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

} // <--- KURUNG KURAWAL PENUTUP INI JUGA WAJIB