<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class ContactMail extends Mailable
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
            from: new Address('globallogistic@gmail.com', 'Global logistic SARL-U'),
            subject: '📩 Nouveau message de contact - ' . $this->contact->fullName,
        );
    }


    
    public function content(): Content
    {
        return new Content(
            view: 'mails.contact',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}