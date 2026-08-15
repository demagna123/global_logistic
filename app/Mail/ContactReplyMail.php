<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class ContactReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('contact@globallogisticsarlu.com', 'Global logistic SARL-U'),
            subject: ' Votre message a été pris en compte - Global Logistics',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.contact-reply',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}