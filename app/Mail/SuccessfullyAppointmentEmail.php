<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class SuccessfullyAppointmentEmail extends Mailable
{
    use Queueable, SerializesModels;

    private string $name;
    private string $appointment;
    /**
     * Create a new message instance.
     */
    public function __construct(
        string $name,
        string $appointment
    )
    {
        $this->name = $name;
        $this->appointment = $appointment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
            replyTo: [
                new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ],
            subject: 'Sikeres foglaláls',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.successfully-appointment',
            text: 'emails.successfully-appointment-text',
            with: [
                'name' => $this->name,
                'appointment' => $this->appointment,
            ],
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
}
