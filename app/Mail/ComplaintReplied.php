<?php
namespace App\Mail;

use App\Models\Complaint;
use App\Models\ComplaintResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComplaintReplied extends Mailable
{
    use Queueable, SerializesModels;

    public $complaint;
    public $response;

    public function __construct(Complaint $complaint, ComplaintResponse $response)
    {
        $this->complaint = $complaint;
        $this->response = $response;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tanggapan Pengaduan: ' . $this->complaint->ticket_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.complaint_replied',
        );
    }
}