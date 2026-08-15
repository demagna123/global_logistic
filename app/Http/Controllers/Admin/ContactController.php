<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Mail\ContactMail;
use App\Mail\ContactReplyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Afficher la liste des messages
     */
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(15);
        $unreadCount = Contact::unread()->count();
        return view('admins.contacts.index', compact('contacts', 'unreadCount'));
    }

    /**
     * Afficher un message spécifique
     */
    public function show(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('admins.contacts.show', compact('contact'));
    }

    /**
     * Marquer un message comme lu avec envoi d'email de confirmation
     */
    public function markAsRead(string $id)
    {
        $contact = Contact::findOrFail($id);

        // Vérifier si déjà lu pour éviter les doublons
        if ($contact->is_read) {
            return redirect()->route('admins.contacts.index')
                ->with('info', 'Ce message est déjà marqué comme lu.');
        }

        // Marquer comme lu
        $contact->markAsRead();

        // Envoyer un email de confirmation au client si un email est présent
        if ($contact->email) {
            try {
                Mail::to($contact->email)->send(new ContactReplyMail($contact));
                Log::info('Email de confirmation envoyé à : ' . $contact->email);
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'envoi de l\'email de confirmation : ' . $e->getMessage());
                // On continue même si l'email échoue
            }
        }

        return redirect()->route('admins.contacts.index')
            ->with('success', 'Message marqué comme lu. Un email de confirmation a été envoyé au client.');
    }

    /**
     * Marquer un message comme non lu
     */
    public function markAsUnread(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->is_read = false;
        $contact->read_at = null;
        $contact->save();

        return redirect()->route('admins.contacts.index')
            ->with('success', 'Message marqué comme non lu.');
    }

    /**
     * Marquer tous les messages comme lus
     */
    public function markAllAsRead()
    {
        $unreadContacts = Contact::unread()->get();

        foreach ($unreadContacts as $contact) {
            $contact->markAsRead();

            // Envoyer l'email de confirmation à chaque client
            if ($contact->email) {
                try {
                    Mail::to($contact->email)->send(new ContactReplyMail($contact));
                } catch (\Exception $e) {
                    Log::error('Erreur d\'envoi pour ' . $contact->email . ' : ' . $e->getMessage());
                }
            }
        }

        $count = $unreadContacts->count();

        return redirect()->route('admins.contacts.index')
            ->with('success', "{$count} message(s) marqué(s) comme lu(s). Des emails de confirmation ont été envoyés.");
    }

    /**
     * Supprimer un message
     */
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admins.contacts.index')
            ->with('success', 'Message supprimé avec succès !');
    }

    /**
     * Store - Gérer l'envoi du formulaire public
     */
    public function store(Request $request)
    {
        try {
            // 1. Valider les données
            $request->validate([
                'nom' => 'required|string|max:255',
                'prenom' => 'required|string|max:255',
                'telephone' => 'required|string|max:50',
                'email' => 'nullable|email|max:255',
                'entreprise' => 'nullable|string|max:255',
                'service' => 'required|string|max:255',
                'message' => 'required|string'
            ]);

            // 2. Créer le contact en base
            $contact = Contact::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => $request->telephone,
                'email' => $request->email,
                'entreprise' => $request->entreprise,
                'service' => $request->service,
                'message' => $request->message,
            ]);

            // 3. Envoyer l'email à l'administrateur
            $adminEmail = env('GLOBAL_MAIL', 'demagnanestor1@gmail.com');
            Mail::to($adminEmail)->send(new ContactMail($contact));

            return redirect()->back()->with('success', 'Votre message a été envoyé avec succès ! Nous vous contacterons dans les plus brefs délais.');
        } catch (\Exception $e) {
            Log::error('Erreur : ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }
}
