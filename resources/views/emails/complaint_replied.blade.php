<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1e293b; color: white; padding: 15px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { border: 1px solid #ddd; padding: 20px; border-top: none; border-radius: 0 0 5px 5px; }
        .box { background: #f1f5f9; padding: 15px; border-left: 4px solid #3b82f6; margin: 15px 0; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Tanggapan Pengaduan</h2>
        </div>
        <div class="content">
            <p>Halo <strong>{{ $complaint->is_anonymous ? 'Pelapor' : $complaint->name }}</strong>,</p>
            <p>Pengaduan Anda dengan nomor tiket <strong>{{ $complaint->ticket_number }}</strong> telah ditanggapi oleh petugas kami.</p>
            
            <div class="box">
                <p><strong>Tanggapan:</strong></p>
                <p>{{ $response->response }}</p>
            </div>

            <p>Status laporan saat ini: <strong>{{ strtoupper($complaint->status) }}</strong>.</p>
            <p>Anda dapat melacak status pengaduan Anda secara berkala melalui tautan di bawah ini:</p>
            <p><a href="{{ route('site.complaints.track') }}" style="background:#1e293b; color:white; padding:10px 15px; text-decoration:none; border-radius:5px; display:inline-block;">Lacak Pengaduan</a></p>
            
            <p>Terima kasih telah menggunakan layanan kami.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Dinas Ketenagakerjaan NTT. Hak cipta dilindungi.
        </div>
    </div>
</body>
</html>