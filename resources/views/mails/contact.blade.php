<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau message de contact</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f7fafc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: #1a365d;
            color: white;
            padding: 25px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.8;
            font-size: 14px;
        }
        .content {
            padding: 30px;
        }
        .content .greeting {
            font-size: 16px;
            color: #2d3748;
            margin-bottom: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
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
            letter-spacing: 0.5px;
            display: block;
        }
        .info-item .value {
            font-size: 15px;
            color: #2d3748;
            font-weight: 600;
            margin-top: 2px;
        }
        .message-box {
            background: #f7fafc;
            border-radius: 8px;
            padding: 16px 20px;
            margin-top: 15px;
            border-left: 4px solid #1a365d;
        }
        .message-box .label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #a0aec0;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 5px;
        }
        .message-box p {
            margin: 0;
            color: #2d3748;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background: #f7fafc;
            font-size: 13px;
            color: #a0aec0;
            border-top: 1px solid #e2e8f0;
        }
        .footer a {
            color: #1a365d;
            text-decoration: none;
        }
        .badge {
            display: inline-block;
            background: #ebf8ff;
            color: #2a69ac;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .info-item.full {
            grid-column: 1 / -1;
        }
        @media (max-width: 480px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .info-item.full {
                grid-column: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📩 Nouveau message de contact</h1>
            <p>Global Logistics - Formulaire de contact</p>
        </div>

        <div class="content">
            <div class="greeting">
                Bonjour, <br>
                Vous avez reçu un nouveau message depuis le formulaire de contact.
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <span class="label">👤 Nom</span>
                    <span class="value">{{ $contact->nom }}</span>
                </div>
                <div class="info-item">
                    <span class="label">👤 Prénom</span>
                    <span class="value">{{ $contact->prenom }}</span>
                </div>
                <div class="info-item">
                    <span class="label">📧 Email</span>
                    <span class="value">{{ $contact->email ?? 'Non renseigné' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">📞 Téléphone</span>
                    <span class="value">{{ $contact->telephone ?? 'Non renseigné' }}</span>
                </div>
                <div class="info-item full">
                    <span class="label">🏢 Entreprise</span>
                    <span class="value">{{ $contact->entreprise ?? 'Non renseignée' }}</span>
                </div>
                <div class="info-item full">
                    <span class="label">🔹 Service demandé</span>
                    <span class="value">
                        <span class="badge">{{ $contact->service }}</span>
                    </span>
                </div>
            </div>

            <div class="message-box">
                <span class="label">💬 Message</span>
                <p>{{ $contact->message }}</p>
            </div>
        </div>

        <div class="footer">
            <p>
                Cet email a été envoyé automatiquement depuis le formulaire de contact de 
                <a href="{{ url('/') }}">Global Logistics</a>.
            </p>
            <p style="margin: 5px 0 0 0; font-size: 12px;">
                Reçu le {{ $contact->created_at->format('d/m/Y à H:i') }}
            </p>
        </div>
    </div>
</body>
</html>