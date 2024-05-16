<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PdfMailable extends Mailable
{
    use Queueable, SerializesModels;

    private $pdf;
    private $data;

    /**
     * Create a new message instance.
     */
    public function __construct($pdf,$data)
    {
        $this->pdf = $pdf;
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('martinezpvivi@gmail.com','Vivian Martínez'),
            subject: 'Pdf Mail App PTV'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.content',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build(){
        return $this->view('user.pdf')
                    ->with('data',$this->data)
                    ->attachData($this->pdf->output(), 'user_data.pdf',['mime' => 'application/pdf']);
    }
}
