@extends('layouts.admin')

@section('title', 'Gestion des actualités - Global Logistics')

@section('header-title', 'Actualités')

@section('content')
<div class="page-toolbar">
    <a href="{{ route('admins.news.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvelle actualité
    </a>
</div>

<!-- Messages de succès/erreur -->
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

<!-- Statistiques -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $news->total() }}</span>
            <span class="stat-label">Total actualités</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $news->where('is_published', true)->count() }}</span>
            <span class="stat-label">Publiées</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">
            <i class="fas fa-pen"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $news->where('is_published', false)->count() }}</span>
            <span class="stat-label">Brouillons</span>
        </div>
    </div>
</div>

<!-- Tableau -->
<div class="table-container">
    @if($news->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Titre</th>
                    <th>Date de publication</th>
                    <th>Statut</th>
                    <th>Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($news as $item)
                    <tr>
                        <td class="text-center">{{ $item->id }}</td>

                        <td>
                            @if($item->images->first())
                                <img 
                                    src="{{ asset('storage/' . $item->images->first()->image_path) }}" 
                                    alt="{{ $item->title }}"
                                    class="thumbnail"
                                >
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>

                        <td>
                            <div class="title-cell">
                                <strong>{{ $item->title }}</strong>
                                @if($item->excerpt)
                                    <span class="excerpt">{{ Str::limit($item->excerpt, 50) }}</span>
                                @endif
                            </div>
                        </td>

                        <td class="text-center">
                            <span class="date-badge">
                                <i class="far fa-calendar-alt"></i>
                                {{ $item->published_date->format('d/m/Y') }}
                            </span>
                        </td>

                        <td class="text-center">
                            @if($item->is_published)
                                <span class="status-badge published">
                                    <i class="fas fa-check-circle"></i> Publié
                                </span>
                            @else
                                <span class="status-badge draft">
                                    <i class="fas fa-pen"></i> Brouillon
                                </span>
                            @endif
                        </td>

                        <td class="text-center">
                            <span class="image-count">
                                <i class="fas fa-images"></i>
                                {{ $item->images->count() }}/3
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admins.news.show', $item->id) }}" 
                                   class="btn-action view" 
                                   title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admins.news.edit', $item->id) }}" 
                                   class="btn-action edit" 
                                   title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admins.news.toggle-publish', $item->id) }}" 
                                      method="POST" 
                                      style="display: inline;">
                                    @csrf
                                    <button type="submit" 
                                            class="btn-action {{ $item->is_published ? 'unpublish' : 'publish' }}"
                                            title="{{ $item->is_published ? 'Dépublier' : 'Publier' }}">
                                        <i class="fas {{ $item->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('admins.news.destroy', $item->id) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette actualité ? Cette action est irréversible.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn-action delete" 
                                            title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-container">
            {{ $news->links() }}
        </div>

    @else
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <h3>Aucune actualité</h3>
            <p>Vous n'avez pas encore créé d'actualité.</p>
            <a href="{{ route('admins.news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer ma première actualité
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
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius, 12px);
        padding: 18px 24px;
        box-shadow: var(--shadow, 0 2px 12px rgba(0,0,0,0.08));
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
    .stat-icon.orange { background: #fffbeb; color: #d69e2e; }

    .stat-info {
        flex: 1;
    }

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

    .table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        font-size: 14px;
    }

    .text-center {
        text-align: center;
    }

    .thumbnail {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e2e8f0;
    }

    .no-image {
        width: 56px;
        height: 56px;
        border-radius: 8px;
        background: #f7fafc;
        border: 2px dashed #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a0aec0;
        font-size: 18px;
    }

    .title-cell {
        display: flex;
        flex-direction: column;
    }

    .title-cell .excerpt {
        font-size: 13px;
        color: #718096;
    }

    .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #4a5568;
        background: #f7fafc;
        padding: 4px 12px;
        border-radius: 20px;
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

    .status-badge.published {
        background: #f0fff4;
        color: #38a169;
    }

    .status-badge.draft {
        background: #fffbeb;
        color: #d69e2e;
    }

    .image-count {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 13px;
        color: #4a5568;
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

    .btn-action.publish { background: #f0fff4; color: #38a169; }
    .btn-action.publish:hover { background: #c6f6d5; }

    .btn-action.unpublish { background: #fff5f5; color: #e53e3e; }
    .btn-action.unpublish:hover { background: #fed7d7; }

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

    @media (max-width: 992px) {
        .table-container {
            overflow-x: auto;
        }
        .table {
            min-width: 800px;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .page-toolbar {
            justify-content: stretch;
        }
        .page-toolbar .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection