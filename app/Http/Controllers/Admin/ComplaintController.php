<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('category')->latest();
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $query->where('title', 'like', '%'.$request->q.'%')
                  ->orWhere('ticket_number', 'like', '%'.$request->q.'%');
        }

        $complaints = $query->paginate(15)->withQueryString();
        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load('category', 'responses.user');
        return view('admin.complaints.show', compact('complaint'));
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate(['status' => 'required|in:pending,proses,selesai']);
        $complaint->update(['status' => $request->status]);
        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function storeResponse(Request $request, Complaint $complaint)
    {
        $request->validate(['response' => 'required|string']);
        
        ComplaintResponse::create([
            'complaint_id' => $complaint->id,
            'user_id' => Auth::id(),
            'response' => $request->response
        ]);

        // Opsional: Jika status masih pending, otomatis ubah ke proses saat dibalas
        if ($complaint->status === 'pending') {
            $complaint->update(['status' => 'proses']);
        }

        return back()->with('success', 'Tanggapan berhasil dikirim.');
    }
}