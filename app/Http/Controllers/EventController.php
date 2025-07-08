<?php

namespace App\Http\Controllers;

use App\Mail\PengajuanEventBaruMail;
use App\Models\PengajuanEvent;
use App\Models\EventKebutuhan;
use App\Models\Brand;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Campaign; // Tambahkan di atas
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PraMember;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EventController extends Controller
{
    public function submission(Request $request)
    {
        $status = $request->query('status', 'Pending');

        $events = PengajuanEvent::withCount('praMembers')
            ->where('status', $status)
            ->latest()
            ->get();

        $brands = Brand::all(); // ✅ TAMBAHKAN INI

        return view('events.submission', compact('events', 'status', 'brands')); // ✅ JANGAN LUPA PASSING
    }

    public function create()
    {
        $brands = Brand::all();
        $campaigns = Campaign::where('status', 'Active')->pluck('name');
        return view('events.create', compact('brands', 'campaigns'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kategori' => 'required|string',
            'status' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'target' => 'nullable|integer',
            'jenis_target' => 'nullable|array',
            'pic_nama' => 'nullable|string|max:255',
            'pic_telp' => 'nullable|string|max:20',
            'anggaran' => 'nullable|integer',
            'jumlah_tim' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'lampiran' => 'nullable|file|max:15360',
            'ttd_upload' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'ttd_drawn' => 'nullable|string',
            'id_brand' => 'required|exists:brands,id',
            'foto_lampiran.*' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // Upload lampiran utama
        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('lampiran_event', 'public');
        }

        // Upload tanda tangan: upload atau dari canvas (base64)
        if ($request->hasFile('ttd_upload')) {
            $validated['ttd'] = $request->file('ttd_upload')->store('ttd_event', 'public');
        } elseif ($request->filled('ttd_drawn') && str_starts_with($request->ttd_drawn, 'data:image')) {
            try {
                $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $request->ttd_drawn);
                $imageData = str_replace(' ', '+', $imageData);
                $filename = 'ttd_' . uniqid() . '.png';
                Storage::disk('public')->put("ttd_event/{$filename}", base64_decode($imageData));
                $validated['ttd'] = "ttd_event/{$filename}";
            } catch (\Exception $e) {
                return back()->withErrors(['ttd_drawn' => 'Gagal menyimpan tanda tangan.']);
            }
        }

        $validated['jenis_target'] = array_filter($request->jenis_target ?? []);
        $validated['user_id'] = auth()->id();

        $event = PengajuanEvent::create($validated);

        // Simpan kebutuhan event
        if ($request->has('kebutuhan')) {
            foreach ($request->kebutuhan as $item) {
                if (!empty($item['nama'])) {
                    EventKebutuhan::create([
                        'pengajuan_event_id' => $event->id,
                        'nama' => $item['nama'],
                        'jumlah' => $item['jumlah'] ?? 0,
                        'tanggal' => $item['tanggal'] ?? now(),
                        'status' => $item['status'] ?? 'Pending',
                    ]);
                }
            }
        }

        // Upload ke NAS jika ada lampiran hasil event
        if ($request->hasFile('foto_lampiran')) {
            foreach ($request->file('foto_lampiran') as $file) {
                $file->store("event_lampiran/{$event->id}", 'sftp-nas');
            }
        }

        // Notifikasi dan email ke semua manager
        $managers = User::where('role', 'manager')->get();
        foreach ($managers as $manager) {
            // Notifikasi internal
            Notifikasi::create([
                'user_id' => $manager->id,
                'pesan' => 'Pengajuan event baru: ' . $event->judul,
                'url' => route('events.show', $event->id, false),
                'dibaca' => false,
            ]);

            // Kirim email
            Mail::to($manager->email)->send(new PengajuanEventBaruMail($event));
        }

        return redirect()->route('events.submission')->with('success', 'Event berhasil ditambahkan.');
    }

    public function show($id)
    {
        $event = PengajuanEvent::with(['kebutuhan', 'brand', 'praMembers'])->findOrFail($id);
        return view('events.show', compact('event'));
    }


    // Mendukung update status via email link GET
    public function updateStatus(Request $request, $id)
    {
        $status = $request->get('status') ?? $request->input('status');

        if (!in_array($status, ['Confirmed', 'Ditolak'])) {
            abort(403, 'Status tidak valid.');
        }

        $event = PengajuanEvent::findOrFail($id);
        $event->status = $status;
        $event->save();

        return redirect()->route('events.show', $id)->with('success', 'Status event diperbarui menjadi ' . $status);
    }
    public function handleEmailAction(Request $request, $id)
    {
        $status = $request->get('status');
        $event = PengajuanEvent::findOrFail($id);

        if (!in_array($status, ['Confirmed', 'Ditolak'])) {
            abort(400, 'Status tidak valid.');
        }

        // Jika event sudah diproses sebelumnya
        if (in_array($event->status, ['Confirmed', 'Ditolak'])) {
            return response()->view('emails.status-processed', [
                'event' => $event,
                'status' => $event->status,
                'alreadyProcessed' => true,
            ]);
        }

        // Update status
        $event->status = $status;
        $event->save();

        // Kirim email ke pembuat event
        Mail::raw("Event \"{$event->judul}\" telah *{$status}* oleh Manager.", function ($message) use ($event, $status) {
            $message->to($event->user->email)
                ->subject("Status Event: {$status}");
        });

        return response()->view('emails.status-processed', [
            'event' => $event,
            'status' => $status,
            'alreadyProcessed' => false,
        ]);
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240',
        ]);

        $file = $request->file('file');
        $data = Excel::toArray([], $file)[0]; // Ambil sheet pertama

        $header = array_map('strtolower', $data[0]); // baris header
        unset($data[0]); // hapus header

        foreach ($data as $row) {
            $row = array_combine($header, $row);

            if (empty($row['judul']) || empty($row['tanggal']) || empty($row['id_brand'])) {
                continue; // skip baris tak lengkap
            }

            PengajuanEvent::create([
                'judul'         => $row['judul'],
                'tanggal'       => Carbon::parse($row['tanggal']),
                'kategori'      => $row['kategori'] ?? 'Umum',
                'status'        => $row['status'] ?? 'Pending',
                'lokasi'        => $row['lokasi'] ?? '-',
                'jumlah_tim'    => $row['jumlah_tim'] ?? 1,
                'id_brand'      => $row['id_brand'],
                'user_id'       => auth()->id(),
            ]);
        }

        return redirect()->route('events.submission')->with('success', 'Data berhasil diimport.');
    }

    public function import_pra_member(Request $request, $eventId)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        $rows = Excel::toArray([], $request->file('file'))[0];
        $header = array_map('strtolower', $rows[0] ?? []);
        unset($rows[0]);

        foreach ($rows as $row) {
            $row = array_combine($header, $row);

            if (empty($row['nama']) || empty($row['telepon'])) {
                continue;
            }

            PraMember::create([
                'pengajuan_event_id' => $eventId,
                'nama' => $row['nama'],
                'telepon' => $row['telepon'],
                'email' => $row['email'] ?? null,
                'keterangan' => $row['keterangan'] ?? null,
            ]);
        }

        return back()->with('success', 'Pra Member berhasil diimpor.');
    }

    public function update(Request $request, $id)
    {
        $event = PengajuanEvent::with('kebutuhan')->findOrFail($id);

        if ($event->status !== 'Pending') {
            return back()->with('error', 'Event hanya dapat diedit jika masih berstatus Pending.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kategori' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'jumlah_tim' => 'required|integer',
            'pic_nama' => 'nullable|string|max:255',
            'pic_telp' => 'nullable|string|max:20',
            'anggaran' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
            'id_brand' => 'nullable|exists:brands,id', // jika diubah juga brand
            'target' => 'nullable|integer',
            'kebutuhan' => 'nullable|array',
            'kebutuhan.*.nama' => 'required|string',
            'kebutuhan.*.jumlah' => 'required|integer|min:0',
            'kebutuhan.*.tanggal' => 'required|date',
            'kebutuhan.*.status' => 'required|string|in:Beli,Pinjam',
        ]);

        // Update data event utama
        $event->update([
            'judul' => $validated['judul'],
            'tanggal' => $validated['tanggal'],
            'kategori' => $validated['kategori'],
            'lokasi' => $validated['lokasi'],
            'jumlah_tim' => $validated['jumlah_tim'],
            'pic_nama' => $validated['pic_nama'] ?? null,
            'pic_telp' => $validated['pic_telp'] ?? null,
            'anggaran' => $validated['anggaran'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'target' => $validated['target'] ?? null,
            'id_brand' => $validated['id_brand'] ?? $event->id_brand,
        ]);

        // Sinkronisasi kebutuhan event
        $event->kebutuhan()->delete(); // hapus semua dulu (simple & aman)
        if ($request->has('kebutuhan')) {
            foreach ($request->kebutuhan as $item) {
                EventKebutuhan::create([
                    'pengajuan_event_id' => $event->id,
                    'nama' => $item['nama'],
                    'jumlah' => $item['jumlah'],
                    'tanggal' => $item['tanggal'],
                    'status' => $item['status'],
                ]);
            }
        }

        return redirect()->route('events.submission', ['status' => 'Pending'])
            ->with('success', 'Event berhasil diperbarui.');
    }
}