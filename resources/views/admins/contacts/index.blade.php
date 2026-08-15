@extends('layouts.admin')

@section('title', 'Gestion des messages - Global Logistics')

@section('header-title', 'Messages reçus')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection
    <style>
        .page-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 18px 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-icon.blue { background: #ebf8ff; color: #2a69ac; }
        .stat-icon.green { background: #f0fff4; color: #38a169; }
        .stat-icon.red { background: #fff5f5; color: #e53e3e; }

        .stat-number {
            font-size: 22px;
            font-weight: 700;
            color: #1a202c;
        }

        .stat-label {
            font-size: 13px;
            color: #4a5568;
            display: block;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: #f7fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .table thead th {
            padding: 12px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #4a5568;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: background 0.2s;
        }

        .table tbody tr:hover {
            background: #f7fafc;
        }

        .table tbody tr.unread {
            background: #fffbeb;
            font-weight: 500;
        }

        .table tbody tr.unread:hover {
            background: #fefcbf;
        }

        .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            font-size: 14px;
        }

        .text-center {
            text-align: center;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
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

        .action-buttons {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-action.view { background: #ebf8ff; color: #2a69ac; }
        .btn-action.view:hover { background: #bee3f8; }

        .btn-action.read { background: #f0fff4; color: #38a169; }
        .btn-action.read:hover { background: #c6f6d5; }

        .btn-action.unread { background: #fffbeb; color: #d69e2e; }
        .btn-action.unread:hover { background: #fefcbf; }

        .btn-action.delete { background: #fff5f5; color: #e53e3e; }
        .btn-action.delete:hover { background: #fed7d7; }

        .pagination-container {
            padding: 16px 20px;
            border-top: 1px solid #e2e8f0;
        }

        .pagination-container nav {
            display: flex;
            justify-content: center;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
        }

        .alert-success {
            background: #f0fff4;
            color: #22543d;
            border: 1px solid #c6f6d5;
        }

        .alert-info {
            background: #ebf8ff;
            color: #2a69ac;
            border: 1px solid #bee3f8;
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

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }

        .btn-success {
            background: #38a169;
            color: white;
        }

        .btn-success:hover {
            background: #2f855a;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 56px;
            margin-bottom: 12px;
        }

        .empty-state h3 {
            font-size: 18px;
            color: #1a202c;
            margin: 0 0 6px 0;
        }

        .empty-state p {
            color: #718096;
            font-size: 14px;
            margin: 0;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            .page-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            .page-toolbar .btn {
                justify-content: center;
            }
            .table-container {
                overflow-x: auto;
            }
            .table {
                min-width: 800px;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

@section('content')
<div class="page-toolbar">
    <div>
        <span style="font-size: 14px; color: #718096;">
            <i class="fas fa-envelope"></i> Gestion des messages reçus
        </span>
    </div>
    @if($unreadCount > 0)
        <form action="{{ route('admins.contacts.mark-all-read') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fas fa-check-double"></i> Tout marquer comme lu
            </button>
        </form>
    @endif
</div>

<!-- Statistiques -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $contacts->total() }}</span>
            <span class="stat-label">Total messages</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $unreadCount }}</span>
            <span class="stat-label">Non lus</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $contacts->total() - $unreadCount }}</span>
            <span class="stat-label">Lus</span>
        </div>
    </div>
</div>

<!-- Messages -->
@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> {{ session('info') }}
    </div>
@endif

<!-- Tableau -->
<div class="table-container">
    @if($contacts->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Expéditeur</th>
                    <th>Service</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                    <tr class="{{ $contact->is_read ? '' : 'unread' }}">
                        <td>#{{ $contact->id }}</td>
                        <td>
                            <div style="font-weight: 500;">{{ $contact->fullName }}</div>
                            <div style="font-size: 13px; color: #718096;">
                                <i class="fas fa-envelope" style="font-size: 11px;"></i> {{ $contact->email ?? 'N/A' }}
                            </div>
                            @if($contact->telephone)
                                <div style="font-size: 12px; color: #a0aec0;">
                                    <i class="fas fa-phone"></i> {{ $contact->telephone }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <span style="background: #ebf8ff; color: #2a69ac; padding: 3px 12px; border-radius: 20px; font-size: 12px;">
                                {{ $contact->service }}
                            </span>
                        </td>
                        <td>
                            <div style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $contact->message }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 13px;">
                                {{ $contact->created_at->format('d/m/Y') }}
                            </div>
                            <div style="font-size: 12px; color: #a0aec0;">
                                {{ $contact->created_at->format('H:i') }}
                            </div>
                        </td>
                        <td>
                            <span class="status-badge {{ $contact->is_read ? 'read' : 'unread' }}">
                                <i class="fas {{ $contact->is_read ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                {{ $contact->is_read ? 'Lu' : 'Non lu' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- Voir -->
                                <a href="{{ route('admins.contacts.show', $contact->id) }}" 
                                   class="btn-action view" 
                                   title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Marquer comme lu -->
                                @if(!$contact->is_read)
                                    <form action="{{ route('admins.contacts.mark-as-read', $contact->id) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action read" title="Marquer comme lu">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admins.contacts.mark-as-unread', $contact->id) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action unread" title="Marquer comme non lu">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                @endif

                                <!-- Supprimer -->
                                <form action="{{ route('admins.contacts.destroy', $contact->id) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $contacts->links() }}
        </div>

    @else
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <h3>Aucun message</h3>
            <p>Vous n'avez pas encore reçu de messages.</p>
        </div>
    @endif
</div>
@endsection