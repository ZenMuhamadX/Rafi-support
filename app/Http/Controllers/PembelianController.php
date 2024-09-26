<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\DataKelas;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembelianController extends Controller
{
    public function pembayaran ()
    {
        return view('user.BuktiPembayaran');
    }
    public function index(DataKelas $id_materi, $id)
    {
        $materi = $id_materi->materi;
        $kelas = DataKelas::findOrFail($id);
        return view('user.payment',  ['kelas' => $kelas, 'materi' => $materi, 'id_materi' => $id_materi]);
    }
    public function uploadBuktiPembayaran(Request $request)
{
    $request->validate([
        'bukti_pembayaran' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $fileName = time() . '_' . $request->file('bukti_pembayaran')->getClientOriginalName();
    $filePath = $request->file('bukti_pembayaran')->storeAs('public/bukti_pembayaran', $fileName);

    // Simpan informasi transaksi ke database
    $pembayaran = new Pembayaran();
    $pembayaran->user_id = auth()->id();
    $pembayaran->kelas_id = $request->kelas_id;
    $pembayaran->bukti_pembayaran = $filePath;
    $pembayaran->status = 'pending'; // status awal "pending"
    $pembayaran->save();

    return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim. Tunggu konfirmasi dari admin.');
}
public function verifikasiPembayaran(Request $request, $id)
{
    $pembayaran = Pembayaran::find($id);
    $pembayaran->status = $request->status;
    $pembayaran->save();

    if ($request->status == 'approved') {
        // Jika disetujui, tambahkan kelas ke akun pengguna
        Pembayaran::create([
            'user_id' => $pembayaran->user_id,
            'kelas_id' => $pembayaran->kelas_id,
        ]);

        // Kirim notifikasi kepada pengguna bahwa pembayaran telah disetujui
        // Code untuk mengirim notifikasi (email atau lainnya)
    }

    return redirect()->back()->with('success', 'Status pembayaran telah diperbarui.');
}


}
