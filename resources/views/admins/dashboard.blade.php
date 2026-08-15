@extends('layouts.admin')

@section('title', 'Tableau de bord - Global Logistics')

@section('header-title', 'Tableau de bord')

@section('content')
<div class="dashboard">
    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ \App\Models\News::count() }}</span>
                <span class="stat-label">Actualités</span>
            </div>
            <div class="stat-link">
                <a href="{{ route('admins.news.index') }}">Voir tout →</a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-file-invoice"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ \App\Models\Quote::count() }}</span>
                <span class="stat-label">Devis</span>
            </div>
            <div class="stat-link">
                <a href="{{ route('admins.quotes.index') }}">Voir tout →</a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ \App\Models\Contact::count() }}</span>
                <span class="stat-label">Messages</span>
            </div>
            <div class="stat-link">
                <a href="">Voir tout →</a>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number">{{ \App\Models\Contact::unread()->count() }}</span>
                <span class="stat-label">Non lus</span>
            </div>
            <div class="stat-link">
                <a href="">Voir tout →</a>
            </div>
        </div>
    </div>

    <!-- Dernières actualités -->
    <div class="dashboard-row">
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-newspaper"></i> Dernières actualités</h3>
                <a href="{{ route('admins.news.index') }}" class="btn-link">Voir tout</a>
            </div>
            <div class="card-body">
                @php $recentNews = \App\Models\News::orderBy('created_at', 'desc')->limit(5)->get(); @endphp
                @if($recentNews->count() > 0)
                    <ul class="list-items">
                        @foreach($recentNews as $news)
                            <li>
                                <span class="list-title">{{ $news->title }}</span>
                                <span class="list-date">{{ $news->created_at->format('d/m/Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="empty-text">Aucune actualité pour le moment.</p>
                @endif
            </div>
        </div>

        <!-- Derniers devis -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-file-invoice"></i> Derniers devis</h3>
                <a href="{{ route('admins.quotes.index') }}" class="btn-link">Voir tout</a>
            </div>
            <div class="card-body">
                @php $recentQuotes = \App\Models\Quote::orderBy('created_at', 'desc')->limit(5)->get(); @endphp
                @if($recentQuotes->count() > 0)
                    <ul class="list-items">
                        @foreach($recentQuotes as $quote)
                            <li>
                                <span class="list-title">{{ $quote->client_name }}</span>
                                <span class="list-status status-{{ $quote->status }}">{{ $quote->status_label }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="empty-text">Aucun devis pour le moment.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Derniers messages -->
    <div class="dashboard-card full-width">
        <div class="card-header">
            <h3><i class="fas fa-envelope"></i> Derniers messages</h3>
            <a href="" class="btn-link">Voir tout</a>
        </div>
        <div class="card-body">
            @php $recentContacts = \App\Models\Contact::orderBy('created_at', 'desc')->limit(5)->get(); @endphp
            @if($recentContacts->count() > 0)
                <ul class="list-items">
                    @foreach($recentContacts as $contact)
                        <li>
                            <span class="list-title">{{ $contact->nom }} {{ $contact->prenom }}</span>
                            <span class="list-subtitle">{{ $contact->email }}</span>
                            <span class="list-status {{ $contact->is_read ? 'read' : 'unread' }}">
                                {{ $contact->is_read ? 'Lu' : 'Non lu' }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="empty-text">Aucun message pour le moment.</p>
            @endif
        </div>
    </div>
</div>

<style>
    .dashboard {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius);
        padding: 20px 24px;
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 16px;
        position: relative;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-icon.blue { background: #ebf8ff; color: #2a69ac; }
    .stat-icon.green { background: #f0fff4; color: #38a169; }
    .stat-icon.orange { background: #fffbeb; color: #d69e2e; }
    .stat-icon.red { background: #fff5f5; color: #e53e3e; }

    .stat-info {
        flex: 1;
    }

    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .stat-label {
        font-size: 13px;
        color: var(--text-gray);
        display: block;
    }

    .stat-link {
        position: absolute;
        bottom: 8px;
        right: 16px;
    }

    .stat-link a {
        font-size: 12px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .stat-link a:hover {
        text-decoration: underline;
    }

    .dashboard-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .dashboard-card {
        background: white;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .dashboard-card.full-width {
        grid-column: 1 / -1;
    }

    .card-header {
        padding: 16px 24px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3 {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header h3 i {
        color: var(--primary);
    }

    .btn-link {
        font-size: 13px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    .card-body {
        padding: 16px 24px;
    }

    .list-items {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .list-items li {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .list-items li:last-child {
        border-bottom: none;
    }

    .list-title {
        font-weight: 500;
        color: var(--text-dark);
        flex: 1;
    }

    .list-subtitle {
        font-size: 13px;
        color: var(--text-gray);
    }

    .list-date {
        font-size: 13px;
        color: var(--text-gray);
    }

    .list-status {
        font-size: 12px;
        font-weight: 600;
        padding: 2px 12px;
        border-radius: 20px;
    }

    .list-status.status-draft { background: #fffbeb; color: #d69e2e; }
    .list-status.status-sent { background: #ebf8ff; color: #2a69ac; }
    .list-status.status-accepted { background: #f0fff4; color: #38a169; }
    .list-status.status-rejected { background: #fff5f5; color: #e53e3e; }
    .list-status.unread { background: #fff5f5; color: #e53e3e; }
    .list-status.read { background: #f0fff4; color: #38a169; }

    .empty-text {
        color: var(--text-light);
        font-size: 14px;
        padding: 10px 0;
        margin: 0;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .dashboard-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-card {
            padding: 16px 20px;
        }

        .list-items li {
            flex-wrap: wrap;
        }
    }
</style>
@endsection