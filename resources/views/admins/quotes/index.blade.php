@extends('layouts.admin')

@section('title', 'Gestion des devis - Global Logistics')

@section('header-title', 'Devis')

@section('content')
<div class="page-toolbar">
    <a href="{{ route('admins.quotes.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouveau devis
    </a>
</div>

<!-- Messages -->
@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> {{ session('info') }}
    </div>
@endif

<!-- Statistiques -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-file-invoice"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $quotes->total() }}</span>
            <span class="stat-label">Total devis</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">
            <i class="fas fa-pen"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $quotes->where('status', 'draft')->count() }}</span>
            <span class="stat-label">Brouillons</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-paper-plane"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $quotes->where('status', 'sent')->count() }}</span>
            <span class="stat-label">Envoyés</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon teal">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $quotes->where('status', 'accepted')->count() }}</span>
            <span class="stat-label">Acceptés</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $quotes->where('status', 'rejected')->count() }}</span>
            <span class="stat-label">Refusés</span>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="filters-container">
    <form action="{{ route('admins.quotes.index') }}" method="GET" class="filters-form">
        <div class="filter-group">
            <label for="status">Statut</label>
            <select name="status" id="status" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                @foreach ($statuses ?? [] as $key => $label)
                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="search">Rechercher</label>
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" name="search" id="search" placeholder="Nom, email, service..."
                    value="{{ request('search') }}" onkeyup="if(event.key === 'Enter') this.form.submit()">
            </div>
        </div>

        <button type="submit" class="btn btn-sm btn-primary">
            <i class="fas fa-filter"></i> Filtrer
        </button>

        @if(request('status') || request('search'))
            <a href="{{ route('admins.quotes.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-times"></i> Réinitialiser
            </a>
        @endif
    </form>
</div>

<!-- Tableau -->
<div class="table-container">
    @if($quotes->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Montant</th>
                    <th>Validité</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotes as $quote)
                    <tr>
                        <td class="text-center">
                            <span class="quote-id">#{{ $quote->id }}</span>
                        </td>

                        <td>
                            <div class="client-info">
                                <strong>{{ $quote->client_name }}</strong>
                                <span class="client-email">{{ $quote->client_email }}</span>
                                @if($quote->client_phone)
                                    <span class="client-phone">
                                        <i class="fas fa-phone"></i> {{ $quote->client_phone }}
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td>
                            <span class="service-badge">
                                {{ $quote->service_type_label }}
                            </span>
                        </td>

                        <td>
                            <span class="amount">
                                {{ $quote->total_amount ? number_format($quote->total_amount, 0, ',', ' ') : '0' }} FCFA
                            </span>
                        </td>

                        <td>
                            @if($quote->valid_until)
                                <span class="validity-badge {{ $quote->valid_until < now() ? 'expired' : 'active' }}">
                                    <i class="fas {{ $quote->valid_until < now() ? 'fa-exclamation-triangle' : 'fa-calendar-check' }}"></i>
                                    {{ $quote->valid_until->format('d/m/Y') }}
                                    @if($quote->valid_until < now())
                                        <span class="expired-label">(Expiré)</span>
                                    @endif
                                </span>
                            @else
                                <span class="text-muted">Non défini</span>
                            @endif
                        </td>

                        <td>
                            <span class="status-badge {{ $quote->status }}">
                                <i class="fas 
                                    {{ $quote->status == 'draft' ? 'fa-pen' : '' }}
                                    {{ $quote->status == 'sent' ? 'fa-paper-plane' : '' }}
                                    {{ $quote->status == 'accepted' ? 'fa-check-circle' : '' }}
                                    {{ $quote->status == 'rejected' ? 'fa-times-circle' : '' }}
                                "></i>
                                {{ $quote->status_label }}
                            </span>
                        </td>

                        <td>
                            <div class="date-info">
                                <span class="date-created">
                                    <i class="far fa-calendar-alt"></i>
                                    {{ $quote->created_at->format('d/m/Y') }}
                                </span>
                                <span class="time-created">
                                    {{ $quote->created_at->format('H:i') }}
                                </span>
                            </div>
                        </td>

                        <td>
                            <div class="action-buttons">
                                <!-- Voir -->
                                <a href="{{ route('admins.quotes.show', $quote->id) }}" 
                                   class="btn-action view" 
                                   title="Voir le devis">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Modifier -->
                                <a href="{{ route('admins.quotes.edit', $quote->id) }}" 
                                   class="btn-action edit" 
                                   title="Modifier le devis">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Changer le statut -->
                                <div class="status-dropdown">
                                    <button class="btn-action status" 
                                            onclick="toggleStatusDropdown({{ $quote->id }})"
                                            title="Changer le statut">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <div class="dropdown-menu" id="statusDropdown{{ $quote->id }}">
                                        @foreach ($statuses ?? [] as $key => $label)
                                            <form action="{{ route('admins.quotes.change-status', $quote->id) }}" 
                                                  method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="{{ $key }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas 
                                                        {{ $key == 'draft' ? 'fa-pen' : '' }}
                                                        {{ $key == 'sent' ? 'fa-paper-plane' : '' }}
                                                        {{ $key == 'accepted' ? 'fa-check-circle' : '' }}
                                                        {{ $key == 'rejected' ? 'fa-times-circle' : '' }}
                                                    "></i>
                                                    {{ $label }}
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- PDF -->
                                <a href="{{ route('admins.quotes.export-pdf', $quote->id) }}" 
                                   class="btn-action pdf" 
                                   title="Exporter en PDF" 
                                   target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                </a>

                                <!-- Supprimer -->
                                <form action="{{ route('admins.quotes.destroy', $quote->id) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce devis ? Cette action est irréversible.')">
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
            {{ $quotes->appends(request()->query())->links() }}
        </div>

    @else
        <!-- État vide -->
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <h3>Aucun devis</h3>
            <p>Vous n'avez pas encore créé de devis.</p>
            <a href="{{ route('admins.quotes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer mon premier devis
            </a>
        </div>
    @endif
</div>

<style>
    /* Styles spécifiques à la page */
    .page-toolbar {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius, 12px);
        padding: 16px 20px;
        box-shadow: var(--shadow, 0 2px 12px rgba(0,0,0,0.08));
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .stat-icon.blue { background: #ebf8ff; color: #2a69ac; }
    .stat-icon.yellow { background: #fffbeb; color: #d69e2e; }
    .stat-icon.green { background: #f0fff4; color: #38a169; }
    .stat-icon.teal { background: #e6fffa; color: #319795; }
    .stat-icon.red { background: #fff5f5; color: #e53e3e; }

    .stat-info {
        flex: 1;
    }

    .stat-number {
        font-size: 20px;
        font-weight: 700;
        color: #1a202c;
    }

    .stat-label {
        font-size: 12px;
        color: #4a5568;
        display: block;
    }

    .filters-container {
        background: white;
        border-radius: var(--radius, 12px);
        padding: 16px 20px;
        margin-bottom: 24px;
        box-shadow: var(--shadow, 0 2px 12px rgba(0,0,0,0.08));
    }

    .filters-form {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 12px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .filter-group label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        color: #a0aec0;
        letter-spacing: 0.5px;
    }

    .filter-group select,
    .filter-group input {
        padding: 8px 12px;
        border: 2px solid #e2e8f0;
        border-radius: 6px;
        font-size: 14px;
        min-width: 140px;
        transition: border-color 0.3s;
    }

    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: #1a365d;
    }

    .search-wrapper {
        position: relative;
    }

    .search-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
    }

    .search-wrapper input {
        padding-left: 34px;
    }

    .table-container {
        background: white;
        border-radius: var(--radius, 12px);
        box-shadow: var(--shadow, 0 2px 12px rgba(0,0,0,0.08));
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
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #4a5568;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .table tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: background 0.2s;
    }

    .table tbody tr:hover {
        background: #f7fafc;
    }

    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        font-size: 14px;
    }

    .text-center {
        text-align: center;
    }
    .text-muted {
        color: #a0aec0;
    }

    .quote-id {
        display: inline-block;
        background: #edf2f7;
        color: #4a5568;
        padding: 2px 10px;
        border-radius: 4px;
        font-weight: 600;
        font-size: 13px;
    }

    .client-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .client-info strong {
        color: #1a365d;
    }

    .client-email {
        font-size: 13px;
        color: #718096;
    }

    .client-phone {
        font-size: 13px;
        color: #718096;
    }

    .client-phone i {
        font-size: 11px;
    }

    .service-badge {
        display: inline-block;
        background: #ebf8ff;
        color: #2a69ac;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .amount {
        font-weight: 700;
        color: #1a365d;
    }

    .validity-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 13px;
        padding: 2px 10px;
        border-radius: 4px;
    }

    .validity-badge.active {
        background: #f0fff4;
        color: #38a169;
    }

    .validity-badge.expired {
        background: #fff5f5;
        color: #e53e3e;
    }

    .validity-badge .expired-label {
        font-size: 11px;
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge.draft { background: #fffbeb; color: #d69e2e; }
    .status-badge.sent { background: #ebf8ff; color: #2a69ac; }
    .status-badge.accepted { background: #f0fff4; color: #38a169; }
    .status-badge.rejected { background: #fff5f5; color: #e53e3e; }

    .date-info {
        display: flex;
        flex-direction: column;
        font-size: 13px;
        color: #4a5568;
    }

    .date-created {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .time-created {
        font-size: 12px;
        color: #a0aec0;
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

    .btn-action.edit { background: #fffbeb; color: #d69e2e; }
    .btn-action.edit:hover { background: #fefcbf; }

    .btn-action.status { background: #e6fffa; color: #319795; }
    .btn-action.status:hover { background: #b2f5ea; }

    .btn-action.pdf { background: #fff5f5; color: #e53e3e; }
    .btn-action.pdf:hover { background: #fed7d7; }

    .btn-action.delete { background: #fff5f5; color: #e53e3e; }
    .btn-action.delete:hover { background: #fed7d7; }

    .status-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        min-width: 160px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        z-index: 100;
        padding: 5px 0;
        margin-top: 5px;
    }

    .dropdown-menu.show {
        display: block;
        animation: slideDown 0.2s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        width: 100%;
        border: none;
        background: none;
        cursor: pointer;
        font-size: 13px;
        color: #2d3748;
        transition: background 0.2s;
        font-family: inherit;
    }

    .dropdown-item:hover {
        background: #f7fafc;
    }

    .dropdown-item i {
        width: 16px;
    }

    .pagination-container {
        padding: 16px 20px;
        border-top: 1px solid #e2e8f0;
    }

    .pagination-container nav {
        display: flex;
        justify-content: center;
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
        margin: 0 0 20px 0;
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

    .alert-danger {
        background: #fff5f5;
        color: #9b2c2c;
        border: 1px solid #fed7d7;
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
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(26, 54, 93, 0.3);
    }

    .btn-secondary {
        background: #e2e8f0;
        color: #2d3748;
    }

    .btn-secondary:hover {
        background: #cbd5e0;
    }

    .btn-sm {
        padding: 8px 16px;
        font-size: 13px;
    }

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
        .table-container {
            overflow-x: auto;
        }
        .table {
            min-width: 1000px;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .filters-form {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-group select,
        .filter-group input {
            min-width: 100%;
        }
        .search-wrapper input {
            min-width: 100%;
        }
        .page-toolbar {
            justify-content: stretch;
        }
        .page-toolbar .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
    // Toggle dropdown pour le statut
    function toggleStatusDropdown(id) {
        const dropdown = document.getElementById('statusDropdown' + id);
        const allDropdowns = document.querySelectorAll('.dropdown-menu');

        allDropdowns.forEach(d => {
            if (d.id !== 'statusDropdown' + id) {
                d.classList.remove('show');
            }
        });

        dropdown.classList.toggle('show');
    }

    document.addEventListener('click', function(event) {
        if (!event.target.closest('.status-dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(d => {
                d.classList.remove('show');
            });
        }
    });
</script>
@endsection