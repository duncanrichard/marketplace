<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    /**
     * Tampilkan semua notifikasi milik user yang login
     */
    public function index()
    {
        $notifikasis = Notifikasi::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifikasi.index', compact('notifikasis'));
    }

    /**
     * Tandai notifikasi sebagai dibaca dan redirect ke URL tujuannya
     */
    public function baca($id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notifikasi) {
            $notifikasi->update(['dibaca' => 1]);

            // Redirect ke URL yang tersimpan di kolom notifikasi
            return redirect($notifikasi->url ?? '/c-panel')
                ->with('success', 'Notifikasi dibaca.');
        }

        return redirect()->back()->with('error', 'Notifikasi tidak ditemukan.');
    }

    /**
     * Simpan notifikasi manual (misal dari form atau API)
     */
    public function simpan(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'pesan' => 'required|string',
            'url' => 'nullable|url',
        ]);

        Notifikasi::create([
            'user_id' => $request->user_id,
            'pesan' => $request->pesan,
            'url' => $request->url,
            'dibaca' => 0,
        ]);

        return back()->with('success', 'Notifikasi berhasil disimpan.');
    }
}
