<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Messages; // Pastikan nama model kamu sudah sesuai (Messages / Message)
use Illuminate\Http\JsonResponse;

class MessagesController extends Controller
{
    // 1. Menampilkan Data Tabel Pesan + Fitur Search + Paginasi
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        // Buat query dasar mengambil pesan terbaru
        $query = Messages::latest();

        // Jika kolom pencarian diisi, saring berdasarkan Nama Pengirim atau Subjek
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('subject', 'LIKE', '%' . $search . '%');
            });
        }

        // Batasi data hanya 10 item per halaman (Mengaktifkan currentPage untuk mencegah bug NaN)
        $messages = $query->paginate(10);

        // Jika request datang dari AJAX (Engine message.js)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'      => true,
                'data'         => $messages->items(),       // Memuntahkan array datanya saja
                'current_page' => $messages->currentPage(), // Mengamankan nomor urut baris tabel
                'last_page'    => $messages->lastPage(),    // Total halaman untuk tombol paginasi
            ]);
        }

        return view('administrator.messageAdm', compact('messages'));
    }

    // 2. Menghapus Data Pesan Permanen via AJAX Modal (Menggunakan ID agar kebal dari salah parameter)
    public function delete($id): JsonResponse
    {
        // Cari datanya berdasarkan ID, otomatis gagalkan dengan eror 404 jika tidak ketemu
        $message = Messages::findOrFail($id);
        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pesan berhasil dihapus dari sistem!'
        ]);
    }
}