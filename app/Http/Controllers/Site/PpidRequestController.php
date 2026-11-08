<?php
namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\PpidRequest;
use Illuminate\Http\Request;

class PpidRequestController extends Controller
{
    public function create($type) {
        if (!in_array($type, ['permohonan', 'keberatan'])) abort(404);
        return view('site.ppid.request_form', compact('type'));
    }

    public function store(Request $request, $type) {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'nik' => 'required|numeric|digits:16',
            'email' => 'required|email|max:150',
            'phone' => 'required|numeric|digits_between:10,15',
            'address' => 'required|string',
            'info_needed' => 'required|string',
            'purpose' => $type === 'permohonan' ? 'required|string' : 'nullable',
        ]);

        $validated['type'] = $type;
        $validated['ticket_number'] = PpidRequest::generateTicketNumber($type);
        
        PpidRequest::create($validated);

        return redirect()->route('site.ppid.track')->with('success_ticket', $validated['ticket_number']);
    }

    public function track() {
        return view('site.ppid.track');
    }

    public function trackResult(Request $request) {
        $request->validate(['ticket_number' => 'required|string']);
        $ticket = PpidRequest::where('ticket_number', $request->ticket_number)->first();
        
        if (!$ticket) return back()->withErrors(['ticket_number' => 'Nomor tiket tidak ditemukan.'])->withInput();
        
        return view('site.ppid.track_result', compact('ticket'));
    }
}