<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('guru');
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_guru', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('bidang_studi', 'like', "%{$search}%");
            });
        }
        
        $guru = $query->paginate(10);
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.guru.table', compact('guru'))->render(),
                'pagination' => $guru->links()->render()
            ]);
        }
        
        return view('admin.guru.index', compact('guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:guru,nip',
            'bidang_studi' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        DB::table('guru')->insert([
            'nama_guru' => $request->nama_guru,
            'nip' => $request->nip,
            'bidang_studi' => $request->bidang_studi,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil ditambahkan');
    }

    public function show($id)
    {
        $guru = DB::table('guru')->where('id', $id)->first();
        return response()->json($guru);
    }

    public function edit($id)
    {
        $guru = DB::table('guru')->where('id', $id)->first();
        return response()->json($guru);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:guru,nip,' . $id,
            'bidang_studi' => 'required|string|max:255',
            'status' => 'required|in:aktif,nonaktif'
        ]);

        DB::table('guru')->where('id', $id)->update([
            'nama_guru' => $request->nama_guru,
            'nip' => $request->nip,
            'bidang_studi' => $request->bidang_studi,
            'status' => $request->status,
            'updated_at' => now()
        ]);

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('guru')->where('id', $id)->delete();
        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil dihapus');
    }
}