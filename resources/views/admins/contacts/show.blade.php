@extends('layouts.admin')

@section('title', 'Message #' . $contact->id . ' - Global Logistics')

@section('header-title', 'Détail du message #' . $contact->id)

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection
    <style>
        .message-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 30px;
            max-width: 900px;
            margin: 0 auto;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .message-header h2 {
            margin: 0;
            color: #1a365d;
        }

        .message-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-item {
            background: #f7fafc;
            padding: 12px 16px;
            border-radius: 8px;
        }

        .info-item .label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #a0aec0;
            display: block;
        }

        .info-item .value {
            font-size: 15px;
            color: #2d3748;
            font-weight: 500;
            margin-top: 2px;
        }

        .message-content {
            background: #f7fafc;
            border-radius: 8px;
            padding: 20px;
            border-left: 4px solid #1a365d;
            margin-bottom: 25px;
        }

        .message-content p {
            margin: 0;
            line-height: 1.8;
            color: #2d3748;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #1a365d;
            color: white;
        }

        .btn-primary:hover {
            background: #2d4a7a;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #2d3748;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
        }

        .btn-success {
            background: #38a169;
            color: white;
        }

        .btn-success:hover {
            background: #2f855a;
        }

        .btn-danger {
            background: #e53e3e;
            color: white;
        }

        .btn-danger:hover {
            background: #c53030;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-badge.read {
            background: #f0fff4;
            color: #38a169;
        }

        .status-badge.unread {
            background: #fff5f5;
            color: #e53e3e;
        }

        @media (max-width: 768px) {
            .message-info {
                grid-template-columns: 1fr;
            }
            .message-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

@section('content')
<div class="message-container">
    <div class="message-header">
        <h2><i class="fas fa-envelope"></i> Message #{{ $contact->id }}</h2>
        <span class="status-badge {{ $contact->is_read ? 'read' : 'unread' }}">
            <i class="fas {{ $contact->is_read ? 'fa-check-circle' : 'fa-clock' }}"></i>
            {{ $contact->is_read ? 'Lu' : 'Non lu' }}
            @if($contact->read_at)
                <span style="font-weight: 400; font-size: 12px; opacity: 0.7;">
                    le {{ $contact->read_at->format('d/m/Y H:i') }}
                </span>
            @endif
        </span>
    </div>

    <div class="message-info">
        <div class="info-item">
            <span class="label">👤 Expéditeur</span>
            <span class="value">{{ $contact->fullName }}</span>
        </div>
        <div class="info-item">
            <span class="label">📧 Email</span>
            <span class="value">{{ $contact->email ?? 'Non renseigné' }}</span>
        </div>
        <div class="info-item">
            <span class="label">📞 Téléphone</span>
            <span class="value">{{ $contact->telephone ?? 'Non renseigné' }}</span>
        </div>
        <div class="info-item">
            <span class="label">🏢 Entreprise</span>
            <span class="value">{{ $contact->entreprise ?? 'Non renseignée' }}</span>
        </div>
        <div class="info-item">
            <span class="label">🔹 Service demandé</span>
            <span class="value">
                <span style="background: #ebf8ff; color: #2a69ac; padding: 3px 12px; border-radius: 20px; font-size: 13px;">
                    {{ $contact->service }}
                </span>
            </span>
        </div>
        <div class="info-item">
            <span class="label">📅 Date de réception</span>
            <span class="value">{{ $contact->created_at->format('d/m/Y à H:i') }}</span>
        </div>
    </div>

    <div class="message-content">
        <p>{{ $contact->message }}</p>
    </div>

    <div class="btn-group">
        @if(!$contact->is_read)
            <form action="{{ route('admins.contacts.mark-as-read', $contact->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i> Marquer comme lu
                </button>
            </form>
        @else
            <form action="{{ route('admins.contacts.mark-as-unread', $contact->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Marquer comme non lu
                </button>
            </form>
        @endif

        <a href="{{ route('admins.contacts.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        <form action="{{ route('admins.contacts.destroy', $contact->id) }}" method="POST" 
              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i> Supprimer
            </button>
        </form>
    </div>
</div>
@endsection