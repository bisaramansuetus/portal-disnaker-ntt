<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpidRequest;
use Illuminate\Http\Request;

class PpidRequestController extends Controller
{
    public function index() {
        $requests = PpidRequest::latest()->paginate(15);
        return view('admin.ppid.requests.index', compact('requests'));
    }

    public function show(PpidRequest $request_item) {
        return view('admin.ppid.requests.show', ['req' => $request_item]);
    }

    public function update(Request $request, PpidRequest $request_item) {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,ditolak',
            'admin_response' => 'nullable|string'
        ]);

        $request_item->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response
        ]);

        return back()->with('success', 'Status dan tanggapan berhasil diperbarui.');
    }
}