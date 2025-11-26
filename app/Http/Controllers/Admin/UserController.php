<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->where('level', $request->role);
        }
        
        // Search berdasarkan username atau email
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('username', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }
    
    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'level' => 'required|in:admin,kesiswaan,guru,wali_kelas,konselor,kepala_sekolah,siswa,orang_tua'
        ];
        
        if ($request->level == 'guru' || $request->level == 'wali_kelas') {
            $rules['guru_id'] = 'required|exists:guru,id';
        }
        
        if ($request->level == 'siswa' || $request->level == 'orang_tua') {
            $rules['siswa_id'] = 'required|exists:siswa,id';
        }
        
        $request->validate($rules);
        
        $userData = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'can_verify' => in_array($request->level, ['admin', 'kesiswaan', 'konselor', 'kepala_sekolah'])
        ];
        
        if ($request->level == 'guru' || $request->level == 'wali_kelas') {
            $userData['guru_id'] = $request->guru_id;
        }
        
        if ($request->level == 'siswa' || $request->level == 'orang_tua') {
            $userData['siswa_id'] = $request->siswa_id;
        }
        
        User::create($userData);
        
        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'level' => 'required|in:admin,kesiswaan,guru,wali_kelas,konselor,kepala_sekolah,siswa,orang_tua'
        ]);
        
        $updateData = [
            'username' => $request->username,
            'email' => $request->email,
            'level' => $request->level,
            'can_verify' => in_array($request->level, ['admin', 'kesiswaan', 'konselor', 'kepala_sekolah'])
        ];
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $updateData['password'] = Hash::make($request->password);
        }
        
        $user->update($updateData);
        
        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Tidak bisa hapus user sendiri
        if ($user->id == auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Tidak dapat menghapus akun sendiri');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')->with('success', 'User berhasil dihapus');
    }
}