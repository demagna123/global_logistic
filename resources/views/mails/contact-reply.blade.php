<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de réception</title>
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
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
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

        .content {
            padding: 30px;
        }

        .content .greeting {
            font-size: 16px;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .message-box {
            background: #f0fff4;
            border-radius: 8px;
            padding: 16px 20px;
            border-left: 4px solid #38a169;
            margin-bottom: 20px;
        }

        .message-box p {
            margin: 0;
            color: #22543d;
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
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>✅ Message reçu</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Bonjour <strong>{{ $contact->prenom }} {{ $contact->nom }}</strong>,<br><br>
                Nous avons bien reçu votre message et nous vous remercions de nous avoir contactés.
            </div>

            <div class="message-box">
                <p><strong>📝 Récapitulatif de votre demande :</strong></p>
                <p style="margin-top: 5px; color: #2d3748;">
                    <strong>Service :</strong> {{ $contact->service }}<br>
                    <strong>Message :</strong> {{ $contact->message }}
                </p>
            </div>

            <p style="color: #4a5568; line-height: 1.6;">
                Nos équipes vont prendre en charge votre demande dans les plus brefs délais.
                Un de nos conseillers vous recontactera très prochainement.
            </p>

            <p style="color: #718096; font-size: 14px; margin-top: 20px;">
                En attendant, n'hésitez pas à consulter notre site pour plus d'informations.
            </p>
        </div>

        <div class="footer">
            <p>
                <a href="{{ url('/') }}">Global Logistics</a> - Votre partenaire logistique de confiance
            </p>
            <p style="margin: 5px 0 0 0; font-size: 12px;">
                Cet email est une confirmation automatique.
            </p>
        </div>
    </div>
</body>

</html>
