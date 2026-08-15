<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Devis #{{ $quote->id }}</title>
    <style>
        /* Styles pour le PDF */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            padding: 30px;
            margin: 0;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #1a365d;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #1a365d;
            font-size: 24px;
            margin: 0;
        }
        
        .header .subtitle {
            color: #718096;
            font-size: 14px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .info-box {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
        }
        
        .info-box h3 {
            color: #1a365d;
            font-size: 14px;
            margin: 0 0 10px 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }
        
        .info-box .label {
            font-weight: bold;
            color: #718096;
            font-size: 11px;
        }
        
        .info-box .value {
            margin-bottom: 6px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .table thead {
            background: #f7fafc;
        }
        
        .table thead th {
            padding: 10px 12px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #4a5568;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .table tbody td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table tfoot td {
            padding: 12px;
            font-weight: 700;
            border-top: 2px solid #1a365d;
        }
        
        .text-right {
            text-align: right;
        }
        
        .total {
            font-size: 18px;
            color: #1a365d;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .status-badge.draft {
            background: #fffbeb;
            color: #d69e2e;
        }
        
        .status-badge.sent {
            background: #ebf8ff;
            color: #2a69ac;
        }
        
        .status-badge.accepted {
            background: #f0fff4;
            color: #38a169;
        }
        
        .status-badge.rejected {
            background: #fff5f5;
            color: #e53e3e;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #a0aec0;
            font-size: 11px;
        }
        
        .service-label {
            background: #ebf8ff;
            color: #2a69ac;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 11px;
        }
        
        .watermark {
            position: fixed;
            bottom: 50px;
            right: 50px;
            opacity: 0.1;
            font-size: 60px;
            color: #1a365d;
            transform: rotate(-20deg);
        }
    </style>
</head>
<body>
    <!-- Filigrane -->
    <div class="watermark">DEVIS</div>

    <!-- En-tête -->
    <div class="header">
        <h1>GLOBAL LOGISTICS</h1>
        <p class="subtitle">Devis n° <strong>#{{ $quote->id }}</strong></p>
        <p style="font-size: 13px; color: #718096;">
            Créé le {{ $quote->created_at->format('d/m/Y à H:i') }}
        </p>
    </div>

    <!-- Informations -->
    <div class="info-grid">
        <!-- Client -->
        <div class="info-box">
            <h3>👤 Client</h3>
            <div class="value"><strong>{{ $quote->client_name }}</strong></div>
            <div class="value">{{ $quote->client_email }}</div>
            @if($quote->client_phone)
                <div class="value">{{ $quote->client_phone }}</div>
            @endif
        </div>

        <!-- Détails du devis -->
        <div class="info-box">
            <h3>📋 Détails</h3>
            <div class="value">
                <span class="service-label">{{ $quote->service_type_label }}</span>
            </div>
            <div class="value">
                <span class="status-badge {{ $quote->status }}">
                    {{ $quote->status_label }}
                </span>
            </div>
            @if($quote->valid_until)
                <div class="value" style="margin-top: 5px;">
                    <span style="font-size: 11px; color: #718096;">Valable jusqu'au :</span>
                    {{ $quote->valid_until->format('d/m/Y') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Description -->
    @if($quote->description)
        <div class="info-box" style="margin-bottom: 20px;">
            <h3>📝 Description de la prestation</h3>
            <p style="margin: 0; line-height: 1.6;">{{ $quote->description }}</p>
        </div>
    @endif

    <!-- Lignes de produit -->
    <h3 style="color: #1a365d; margin: 20px 0 10px 0;">📦 Lignes de produit</h3>
    
    <table class="table">
        <thead>
            <tr>
                <th style="width: 40%;">Description</th>
                <th style="width: 20%; text-align: center;">Quantité</th>
                <th style="width: 20%; text-align: right;">Prix unitaire</th>
                <th style="width: 20%; text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quote->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">
                        {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA
                    </td>
                    <td style="text-align: right;">
                        {{ number_format($item->total, 0, ',', ' ') }} FCFA
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; font-size: 16px;">
                    <strong>Total général</strong>
                </td>
                <td style="text-align: right; font-size: 18px; color: #1a365d;">
                    <strong>{{ number_format($quote->total_amount, 0, ',', ' ') }} FCFA</strong>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- Notes internes -->
    @if($quote->admin_notes)
        <div style="margin-top: 30px; padding: 15px; background: #f7fafc; border-radius: 8px;">
            <p style="font-size: 11px; color: #718096; margin: 0;">
                <strong>Notes internes :</strong><br>
                {{ $quote->admin_notes }}
            </p>
        </div>
    @endif

    <!-- Pied de page -->
    <div class="footer">
        <p>
            Global Logistics - Tous droits réservés<br>
            Ce devis est valable 30 jours à compter de la date d'émission.
        </p>
    </div>
</body>
</html>