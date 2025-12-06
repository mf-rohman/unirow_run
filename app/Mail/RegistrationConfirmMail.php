<?php
namespace App\Mail;

use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmMail extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $url;

    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
        // Membuat Link Verifikasi yang aman (Signed URL)
        $this->url = \Illuminate\Support\Facades\URL::signedRoute(
            'participant.verify', 
            ['id' => $participant->id]
        );
    }

    public function build()
    {
        return $this->subject('🔔 Konfirmasi Pendaftaran Unirow Run 2025')
                    ->view('emails.registration_confirm');
    }
}