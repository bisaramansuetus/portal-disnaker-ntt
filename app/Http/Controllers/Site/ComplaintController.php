<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function create()
    {
        $categories = ComplaintCategory::all();
        return view('site.complaints.create', compact('categories'));
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
            'category_id' => 'required|exists:complaint_categories,id',
            'title'       => 'required|string|max:200',
            'content'     => 'required|string',
            'photo_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'is_anonymous'=> 'nullable|boolean',
            'name'        => 'required_unless:is_anonymous,1|nullable|string|max:150',
            
            // VALIDASI NIK: Harus angka, tepat 16 digit
            'nik'         => 'required_unless:is_anonymous,1|nullable|numeric|digits:16',
            
            'job'         => 'required_unless:is_anonymous,1|nullable|string|max:100',
            'address'     => 'required_unless:is_anonymous,1|nullable|string',
            
            // VALIDASI NO HP: Harus angka, panjang 10 sampai 15 digit
            'phone'       => 'required_unless:is_anonymous,1|nullable|numeric|digits_between:10,15',
            
            'email'       => 'required_unless:is_anonymous,1|nullable|email|max:150',
        ], [
            // PESAN ERROR KUSTOM (Opsional, agar lebih ramah)
            'nik.digits' => 'NIK harus terdiri dari tepat 16 digit angka.',
            'phone.digits_between' => 'Nomor HP tidak valid (harus 10-15 digit angka).'
        ]);

        $validated['ticket_number'] = Complaint::generateTicketNumber();
        $validated['is_anonymous'] = $request->boolean('is_anonymous');
        $validated['status'] = 'pending';

        if ($request->hasFile('photo_proof')) {
            $validated['photo_proof'] = $request->file('photo_proof')->store('complaints', 'public');
        }

        $complaint = Complaint::create($validated);

        // Redirect ke halaman sukses dengan membawa nomor tiket
        return redirect()->route('site.complaints.track')
            ->with('success_ticket', $complaint->ticket_number)
            ->with('success_msg', 'Pengaduan berhasil dikirim! Simpan Nomor Tiket Anda untuk melacak status.');
    }

    public function track()
    {
        return view('site.complaints.track');
    }

    public function trackResult(Request $request)
    {
        $request->validate(['ticket_number' => 'required|string']);

        $complaint = Complaint::with(['category', 'responses.user'])
            ->where('ticket_number', $request->ticket_number)
            ->first();

        if (!$complaint) {
            return back()->withErrors(['ticket_number' => 'Nomor tiket tidak ditemukan. Pastikan penulisan sudah benar.'])->withInput();
        }

        return view('site.complaints.result', compact('complaint'));
    }
}