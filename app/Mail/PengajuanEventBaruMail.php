<?php

namespace App\Mail;

use App\Models\PengajuanEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class PengajuanEventBaruMail extends Mailable
{
    use Queueable, SerializesModels;

    public $event;
    public $verifyUrl;
    public $rejectUrl;

    public function __construct(PengajuanEvent $event)
    {
        $this->event = $event;

        // Generate signed URLs untuk tombol di email
        $this->verifyUrl = URL::signedRoute('events.handle-email-action', [
            'id' => $this->event->id,
            'status' => 'Confirmed'
        ]);

        $this->rejectUrl = URL::signedRoute('events.handle-email-action', [
            'id' => $this->event->id,
            'status' => 'Ditolak'
        ]);
    }

    public function build()
    {
        return $this->subject('Pengajuan Event Baru: ' . $this->event->judul)
                    ->view('emails.pengajuan-event')
                    ->with([
                        'event' => $this->event,
                        'verifyUrl' => $this->verifyUrl,
                        'rejectUrl' => $this->rejectUrl,
                    ]);
    }
}
