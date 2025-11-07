<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Khotbah;
use Illuminate\Support\Facades\Log;



class KhotbahController extends Controller
{
    public function index()
    {
        $khotbah = Khotbah::all();

        if ($khotbah->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada khotbah yang ditemukan.'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => ' khotbah ditemukan.',
            'data' => $khotbah
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
{
    // 🔍 Validasi input data
    $validated = $request->validate([
        'judul' => 'required|string|max:50',      
        'isi' => 'required|string|max:2000',
        'author' => 'required|string|max:255',
        'tanggal' => 'required|string|max:255',
       

        
    ]);

    // 💾 Simpan data ke database
    $khotbah = Khotbah::create($validated);

    // ✅ Jika berhasil ditambahkan
    if ($khotbah) {
        return response()->json([
            'success' => true,
            'message' => 'Khotbah baru berhasil ditambahkan.',
            'data'    => $khotbah
        ], \Illuminate\Http\Response::HTTP_CREATED);
    }

    // ❌ Jika gagal menyimpan
    return response()->json([
        'success' => false,
        'message' => 'Gagal menambahkan khotbah.'
    ], \Illuminate\Http\Response::HTTP_BAD_REQUEST);
}

//kodingan untuk post/ atau edit
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
        $khotbah = Khotbah::find($id);
        if (!$khotbah) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        // Ambil data dari request
        $data = [
            'judul' => $request->input('judul'),
            'isi' => $request->input('isi'),
            'author' => $request->input('author'),
            'tanggal' => $request->input('tanggal'),
            
        ];

        // Validasi data
        $validate = validator($data, [
            'judul' => 'required|string|max:50',
            'isi' => 'required|string|max:2000',
            'author' => 'required|string|max:25',
            'tanggal' => 'required|string|max:50',
            
        ])->validate();

        // Update jadwal
        $khotbah->fill($data);
        $khotbah->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Khotbah berhasil diperbarui.',
            'data' => $khotbah
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

        'judul' => 'required|string|max:50',
        'isi' => 'required|string|max:2000',
        'author' => 'required|string|max:25',
        'tanggal' => 'required|string|max:50',
        ]);

        $khotbah = Khotbah::find($id);
        if (!$khotbah) {
            return response()->json([
                'success' => false,
                'message' => 'Khotbah tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $khotbah->update($validate);
        
        return response()->json([
            'success' => true,
            'message' => 'khotbah berhasil diperbarui.',
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

}



