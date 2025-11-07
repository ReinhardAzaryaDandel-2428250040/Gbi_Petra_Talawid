<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Log;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwal = Jadwal::all();

        if ($jadwal->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada jadwal yang ditemukan.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => ' jadwal Ibadah ditemukan.',
            'data' => $jadwal
        ], Response::HTTP_OK);
    }

    // kodingan untuk post/ atau create nya dari jadwal

   public function store(Request $request)
{
    // 🔍 Validasi input data
    $validated = $request->validate([
        'hari' => 'required|string|max:50',
        'jam' => 'required|string|max:20',
        'penghotbah' => 'required|string|max:255',
        'worship_leader' => 'required|string|max:255',
        'kegiatan' => 'required|string|max:255',
        'tempat' => 'nullable|string|max:255',

        
    ]);

    // 💾 Simpan data ke database
    $jadwal = Jadwal::create($validated);

    // ✅ Jika berhasil ditambahkan
    if ($jadwal) {
        return response()->json([
            'success' => true,
            'message' => 'Jadwal ibadah baru berhasil ditambahkan.',
            'data'    => $jadwal
        ], \Illuminate\Http\Response::HTTP_CREATED);
    }

    // ❌ Jika gagal menyimpan
    return response()->json([
        'success' => false,
        'message' => 'Gagal menambahkan jadwal ibadah.'
    ], \Illuminate\Http\Response::HTTP_BAD_REQUEST);
}

//Kodingan untuk update data atau edit
public function update(Request $request, $id)
{
    try {
        // Log request data untuk debugging
        Log::info('Update request received:', [
            'input' => $request->input(),
            'all' => $request->all(),
            'post' => $_POST,
            'method' => $request->method()
        ]);

        // Cek apakah jadwal ada
        $jadwal = Jadwal::find($id);
        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        // Ambil data dari request
        $data = [
            'hari' => $request->input('hari'),
            'jam' => $request->input('jam'),
            'penghotbah' => $request->input('penghotbah'),
            'worship_leader' => $request->input('worship_leader'),
            'kegiatan' => $request->input('kegiatan'),
            'tempat' => $request->input('tempat')
        ];

        // Validasi data
        $validate = validator($data, [
            'hari' => 'required|string|max:50',
            'jam' => 'required|string|max:20',
            'penghotbah' => 'required|string|max:255',
            'worship_leader' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
            'tempat' => 'nullable|string|max:255',
        ])->validate();

        // Update jadwal
        $jadwal->fill($data);
        $jadwal->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Jadwal ibadah berhasil diperbarui.',
            'data' => $jadwal
        ], Response::HTTP_OK);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak valid',
            'errors' => $e->errors(),
            'received_data' => $request->all()
        ], Response::HTTP_BAD_REQUEST);
    } catch (\Exception $e) {
        Log::error('Update error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'received_data' => $request->all()
        ], Response::HTTP_BAD_REQUEST);
    }
    
    try {
        $validate = $request->validate([
            'hari' => 'required|string|max:50',
            'jam' => 'required|string|max:20',
            'penghotbah' => 'required|string|max:255',
            'worship_leader' => 'required|string|max:255',
            'kegiatan' => 'required|string|max:255',
            'tempat' => 'nullable|string|max:255',
        ]);

        $jadwal = Jadwal::find($id);
        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $jadwal->update($validate);
        
        return response()->json([
            'success' => true,
            'message' => 'Jadwal ibadah berhasil diperbarui.',
            'data' => $jadwal
        ], Response::HTTP_OK);
    } catch (\Exception $e) {
        Log::error('Update error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'received_data' => $request->all()
        ], Response::HTTP_BAD_REQUEST);
    }
}

// Function untuk menampilkan satu jadwal berdasarkan id
public function show($id)
{
    $jadwal = Jadwal::find($id);

    if (!$jadwal) {
        return response()->json([
            'success' => false,
            'message' => 'Jadwal ibadah tidak ditemukan.'
        ], Response::HTTP_NOT_FOUND);
    }

    return response()->json([
        'success' => true,
        'message' => 'Jadwal ibadah ditemukan.',
        'data' => $jadwal
    ], Response::HTTP_OK);
}


}
