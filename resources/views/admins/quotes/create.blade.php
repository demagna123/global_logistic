@extends('layouts.admin')

@section('title', 'Créer un devis - Global Logistics')

@section('header-title', 'Créer un devis')

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
    <form action="{{ route('admins.quotes.store') }}" method="POST" id="quoteForm">
        @csrf

        <div class="form-grid">
            <!-- Colonne gauche : Infos client -->
            <div class="form-card">
                <div class="card-header">
                    <h2><i class="fas fa-user"></i> Informations client</h2>
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <label for="client_name">Nom du client <span class="required">*</span></label>
                        <input type="text" id="client_name" name="client_name" value="{{ old('client_name') }}"
                            placeholder="Ex: Jean Dupont" required>
                        @error('client_name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="client_email">Email <span class="required">*</span></label>
                            <input type="email" id="client_email" name="client_email"
                                value="{{ old('client_email') }}" placeholder="client@email.com" required>
                            @error('client_email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="client_phone">Téléphone</label>
                            <input type="text" id="client_phone" name="client_phone"
                                value="{{ old('client_phone') }}" placeholder="+228 90 00 00 00">
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
                            @foreach ($serviceTypes as $key => $label)
                                <option value="{{ $key }}"
                                    {{ old('service_type') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_type')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description de la prestation <span
                                class="required">*</span></label>
                        <textarea id="description" name="description" rows="4" placeholder="Décrivez la prestation demandée..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="valid_until">Valable jusqu'au</label>
                            <input type="date" id="valid_until" name="valid_until"
                                value="{{ old('valid_until') }}">
                            @error('valid_until')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Statut <span class="required">*</span></label>
                            <select id="status" name="status" required>
                                @foreach ($statuses as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('status', 'draft') == $key ? 'selected' : '' }}>
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
                        <textarea id="admin_notes" name="admin_notes" rows="3"
                            placeholder="Notes internes pour l'administrateur (non visible par le client)">{{ old('admin_notes') }}</textarea>
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
                <h2><i class="fas fa-list"></i> Lignes de produit</h2>
                <button type="button" class="btn btn-primary" id="addItemBtn">
                    <i class="fas fa-plus"></i> Ajouter une ligne
                </button>
            </div>

            <div class="card-body">
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
                            <!-- Les lignes seront ajoutées ici dynamiquement -->
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

                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Ajoutez les produits ou services proposés dans ce devis.
                </div>
            </div>
        </div>

        <!-- Boutons -->
        <div class="form-actions">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Créer le devis
            </button>
            <a href="{{ route('admins.quotes.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Annuler
            </a>
        </div>
    </form>
</div>


@endsection
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemsBody = document.getElementById('itemsBody');
            const addItemBtn = document.getElementById('addItemBtn');
            const grandTotalEl = document.getElementById('grandTotal');
            let itemCount = 0;

            // Ajouter une ligne
            addItemBtn.addEventListener('click', function() {
                addItemRow();
            });

            // Ajouter une ligne vide
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

                // Écouter les changements pour recalculer
                const inputs = row.querySelectorAll('input');
                inputs.forEach(input => {
                    input.addEventListener('input', function() {
                        updateRowTotal(row);
                        calculateGrandTotal();
                    });
                    input.addEventListener('change', function() {
                        updateRowTotal(row);
                        calculateGrandTotal();
                    });
                });
            }

            // Calculer le total d'une ligne
            function updateRowTotal(row) {
                const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
                const price = parseFloat(row.querySelector('.item-price').value) || 0;
                const total = quantity * price;
                row.querySelector('.item-total').textContent = total.toFixed(2);
            }

            // Calculer le total général
            function calculateGrandTotal() {
                const totals = document.querySelectorAll('.item-total');
                let grandTotal = 0;
                totals.forEach(el => {
                    grandTotal += parseFloat(el.textContent) || 0;
                });
                grandTotalEl.textContent = grandTotal.toFixed(2) + ' FCFA';
            }

            // Supprimer une ligne
            window.removeItem = function(button) {
                const row = button.closest('.item-row');
                if (document.querySelectorAll('.item-row').length > 1) {
                    row.remove();
                    calculateGrandTotal();
                } else {
                    alert('Vous devez avoir au moins une ligne de produit.');
                }
            };

            // Ajouter une ligne par défaut si le formulaire est vide
            @if (old('items') && count(old('items')) > 0)
                @foreach (old('items') as $item)
                    addItemRow('{{ $item['description'] ?? '' }}', {{ $item['quantity'] ?? 1 }},
                        {{ $item['unit_price'] ?? 0 }});
                @endforeach
            @else
                addItemRow('', 1, 0);
            @endif

            // Ajouter une ligne au chargement si aucune ligne existante
            setTimeout(function() {
                if (document.querySelectorAll('.item-row').length === 0) {
                    addItemRow('', 1, 0);
                }
                calculateGrandTotal();
            }, 100);
        });
    </script>