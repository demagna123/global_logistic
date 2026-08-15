@extends('layouts.admin')

@section('title', 'Modifier le devis #' . $quote->id . ' - Global Logistics')

@section('header-title', 'Modifier le devis #' . $quote->id)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/quote-form.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@endsection
    @vite(['resources/css/quote-form.css'])

@section('content')
<div class="container">
    <!-- Messages d'erreur -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulaire -->
    <form action="{{ route('admins.quotes.update', $quote->id) }}" method="POST" id="quoteForm">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <!-- Colonne gauche : Infos client -->
            <div class="form-card">
                <div class="card-header">
                    <h2><i class="fas fa-user"></i> Informations client</h2>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="client_name">Nom du client <span class="required">*</span></label>
                        <input 
                            type="text" 
                            id="client_name" 
                            name="client_name" 
                            value="{{ old('client_name', $quote->client_name) }}"
                            placeholder="Ex: Jean Dupont"
                            required
                        >
                        @error('client_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="client_email">Email <span class="required">*</span></label>
                            <input 
                                type="email" 
                                id="client_email" 
                                name="client_email" 
                                value="{{ old('client_email', $quote->client_email) }}"
                                placeholder="client@email.com"
                                required
                            >
                            @error('client_email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="client_phone">Téléphone</label>
                            <input 
                                type="text" 
                                id="client_phone" 
                                name="client_phone" 
                                value="{{ old('client_phone', $quote->client_phone) }}"
                                placeholder="+228 90 00 00 00"
                            >
                            @error('client_phone')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne droite : Détails du devis -->
            <div class="form-card">
                <div class="card-header">
                    <h2><i class="fas fa-file-invoice"></i> Détails du devis</h2>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="service_type">Type de service <span class="required">*</span></label>
                        <select id="service_type" name="service_type" required>
                            <option value="">Sélectionnez un service</option>
                            @foreach($serviceTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('service_type', $quote->service_type) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_type')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description de la prestation <span class="required">*</span></label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            placeholder="Décrivez la prestation demandée..."
                            required
                        >{{ old('description', $quote->description) }}</textarea>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="valid_until">Valable jusqu'au</label>
                            <input 
                                type="date" 
                                id="valid_until" 
                                name="valid_until" 
                                value="{{ old('valid_until', $quote->valid_until ? $quote->valid_until->format('Y-m-d') : '') }}"
                            >
                            @error('valid_until')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Statut <span class="required">*</span></label>
                            <select id="status" name="status" required>
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', $quote->status) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="admin_notes">Notes internes</label>
                        <textarea 
                            id="admin_notes" 
                            name="admin_notes" 
                            rows="3"
                            placeholder="Notes internes pour l'administrateur (non visible par le client)"
                        >{{ old('admin_notes', $quote->admin_notes) }}</textarea>
                        @error('admin_notes')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Lignes de produit -->
        <div class="form-card">
            <div class="card-header">
                <div class="items-header">
                    <h2><i class="fas fa-list"></i> Lignes de produit</h2>
                    <span class="count-badge">{{ $quote->items->count() }} lignes</span>
                </div>
                <button type="button" class="btn btn-primary" id="addItemBtn">
                    <i class="fas fa-plus"></i> Ajouter une ligne
                </button>
            </div>

            <div class="card-body">
                <!-- Lignes existantes -->
                @if($quote->items->count() > 0)
                    <div style="margin-bottom: 20px;">
                        <label style="font-weight: 600; font-size: 14px; color: #2d3748; display: block; margin-bottom: 10px;">
                            <i class="fas fa-check-circle" style="color: #38a169;"></i> Lignes existantes
                        </label>
                        @foreach($quote->items as $item)
                            <div class="existing-item" id="existingItem{{ $item->id }}">
                                <div class="item-info">
                                    <span class="desc">{{ $item->description }}</span>
                                    <span>Qté: {{ $item->quantity }}</span>
                                    <span>{{ number_format($item->unit_price, 0, ',', ' ') }} FCFA</span>
                                    <span style="font-weight: 700; color: #1a365d;">
                                        Total: {{ number_format($item->total, 0, ',', ' ') }} FCFA
                                    </span>
                                </div>
                                <div>
                                    <input 
                                        type="hidden" 
                                        name="existing_items[{{ $item->id }}][description]" 
                                        value="{{ $item->description }}"
                                    >
                                    <input 
                                        type="hidden" 
                                        name="existing_items[{{ $item->id }}][quantity]" 
                                        value="{{ $item->quantity }}"
                                    >
                                    <input 
                                        type="hidden" 
                                        name="existing_items[{{ $item->id }}][unit_price]" 
                                        value="{{ $item->unit_price }}"
                                    >
                                    <input 
                                        type="hidden" 
                                        name="existing_items[{{ $item->id }}][id]" 
                                        value="{{ $item->id }}"
                                    >
                                    <input 
                                        type="hidden" 
                                        name="deleted_items[]" 
                                        id="deleted_item_{{ $item->id }}"
                                        value=""
                                    >
                                    <button 
                                        type="button" 
                                        class="btn-remove-existing" 
                                        onclick="toggleDeleteItem({{ $item->id }}, this)"
                                    >
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        <div class="help-text" style="margin-top: 10px;">
                            <i class="fas fa-info-circle"></i> 
                            Cliquez sur "Supprimer" pour marquer une ligne à supprimer. La suppression sera effective lors de l'enregistrement.
                        </div>
                    </div>
                    <hr class="section-divider">
                @endif

                <!-- Nouvelles lignes -->
                <div>
                    <label style="font-weight: 600; font-size: 14px; color: #2d3748; display: block; margin-bottom: 10px;">
                        <i class="fas fa-plus-circle" style="color: #2a69ac;"></i> Nouvelles lignes
                    </label>
                    <div class="table-container">
                        <table class="items-table" id="itemsTable">
                            <thead>
                                <tr>
                                    <th style="width: 40%;">Description</th>
                                    <th style="width: 20%;">Quantité</th>
                                    <th style="width: 25%;">Prix unitaire (FCFA)</th>
                                    <th style="width: 20%;">Total (FCFA)</th>
                                    <th style="width: 50px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                <!-- Les nouvelles lignes seront ajoutées ici -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total général</strong></td>
                                    <td colspan="2">
                                        <strong id="grandTotal">0 FCFA</strong>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="help-text" style="margin-top: 10px;">
                        <i class="fas fa-info-circle"></i> 
                        Ajoutez de nouveaux produits ou services à ce devis.
                    </div>
                </div>
            </div>
        </div>

        <!-- Boutons -->
        <div class="form-actions">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Mettre à jour le devis
            </button>
            <a href="{{ route('admins.quotes.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Annuler
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $quote->id }})">
                <i class="fas fa-trash-alt"></i> Supprimer le devis
            </button>
        </div>
    </form>

    <!-- Form de suppression caché -->
    <form id="deleteForm" action="{{ route('admins.quotes.destroy', $quote->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemsBody = document.getElementById('itemsBody');
            const addItemBtn = document.getElementById('addItemBtn');
            const grandTotalEl = document.getElementById('grandTotal');
            let itemCount = 0;

            // Initialiser les totaux des lignes existantes
            function calculateExistingTotal() {
                let grandTotal = 0;
                
                // Calculer les totaux des lignes existantes
                document.querySelectorAll('.existing-item').forEach(item => {
                    const totalText = item.querySelector('.item-info span:last-child');
                    if (totalText) {
                        const total = parseFloat(totalText.textContent.replace(/[^0-9]/g, '')) || 0;
                        grandTotal += total;
                    }
                });

                // Calculer les totaux des nouvelles lignes
                document.querySelectorAll('.item-total').forEach(el => {
                    grandTotal += parseFloat(el.textContent) || 0;
                });

                grandTotalEl.textContent = grandTotal.toFixed(2) + ' FCFA';
            }

            // Ajouter une ligne
            addItemBtn.addEventListener('click', function() {
                addItemRow();
            });

            function addItemRow(description = '', quantity = 1, unitPrice = 0) {
                const row = document.createElement('tr');
                row.className = 'item-row';
                row.dataset.index = itemCount;

                row.innerHTML = `
                    <td>
                        <input 
                            type="text" 
                            name="items[${itemCount}][description]" 
                            class="item-description" 
                            placeholder="Description du produit/service"
                            value="${description}"
                            required
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            name="items[${itemCount}][quantity]" 
                            class="item-quantity" 
                            value="${quantity}" 
                            min="1"
                            required
                        >
                    </td>
                    <td>
                        <input 
                            type="number" 
                            name="items[${itemCount}][unit_price]" 
                            class="item-price" 
                            value="${unitPrice}" 
                            min="0" 
                            step="0.01"
                            placeholder="0.00"
                            required
                        >
                    </td>
                    <td>
                        <span class="item-total">${(quantity * unitPrice).toFixed(2)}</span>
                    </td>
                    <td>
                        <button type="button" class="btn-remove" onclick="removeItem(this)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;

                itemsBody.appendChild(row);
                itemCount++;

                const inputs = row.querySelectorAll('input');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        updateRowTotal(row);
                        calculateExistingTotal();
                    });
                    input.addEventListener('change', function() {
                        updateRowTotal(row);
                        calculateExistingTotal();
                    });
                });

                calculateExistingTotal();
            }

            function updateRowTotal(row) {
                const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                const total = quantity * price;
                row.querySelector('.item-total').textContent = total.toFixed(2);
            }

            window.removeItem = function(button) {
                const row = button.closest('.item-row');
                row.remove();
                calculateExistingTotal();
            };

            // Ajouter les lignes existantes déjà présentes
            @if(old('items') && count(old('items')) > 0)
                @foreach(old('items') as $item)
                    addItemRow('{{ $item['description'] ?? '' }}', {{ $item['quantity'] ?? 1 }}, {{ $item['unit_price'] ?? 0 }});
                @endforeach
            @endif

            // Calculer le total initial
            setTimeout(function() {
                calculateExistingTotal();
            }, 200);

            // Fonction pour supprimer une ligne existante
            window.toggleDeleteItem = function(itemId, button) {
                const hiddenInput = document.getElementById('deleted_item_' + itemId);
                const existingItem = document.getElementById('existingItem' + itemId);
                
                if (hiddenInput.value === '') {
                    hiddenInput.value = itemId;
                    button.classList.add('active');
                    button.innerHTML = '<i class="fas fa-undo"></i> Annuler';
                    existingItem.style.opacity = '0.5';
                    existingItem.style.textDecoration = 'line-through';
                    existingItem.style.borderLeftColor = '#e53e3e';
                } else {
                    hiddenInput.value = '';
                    button.classList.remove('active');
                    button.innerHTML = '<i class="fas fa-trash-alt"></i> Supprimer';
                    existingItem.style.opacity = '1';
                    existingItem.style.textDecoration = 'none';
                    existingItem.style.borderLeftColor = '#2a69ac';
                }
            };

            // Confirmation de suppression
            window.confirmDelete = function(id) {
                if (confirm('Êtes-vous sûr de vouloir supprimer ce devis ? Cette action est irréversible.')) {
                    document.getElementById('deleteForm').submit();
                }
            };
        });
    </script>