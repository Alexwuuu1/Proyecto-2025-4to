<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de Voluntariado</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 40px;
            background: white;
            color: #333;
        }
        .certificate {
            border: 5px solid #2c3e50;
            padding: 40px;
            text-align: center;
            position: relative;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .subtitle {
            font-size: 24px;
            margin-bottom: 30px;
            color: #34495e;
        }
        .content {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .name {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
            color: #e74c3c;
        }
        .details {
            font-size: 16px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #7f8c8d;
        }
        .signature {
            margin-top: 40px;
            border-top: 2px solid #2c3e50;
            padding-top: 20px;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
        .certificate-number {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="certificate-number">N°: {{ $certificate->certificate_number }}</div>

        <div class="header">
            UNIVERSIDAD FRANCISCO DE VITORIA
        </div>

        <div class="subtitle">
            Sistema de Voluntariado UNIFRANZ
        </div>

        <div class="content">
            Se certifica que
        </div>

        <div class="name">
            {{ $certificate->user->name }}
        </div>

        <div class="content">
            ha completado satisfactoriamente {{ $certificate->total_hours }} horas de voluntariado
            en actividades organizadas por la Universidad Francisco de Vitoria.
        </div>

        @if($certificate->description)
            <div class="details">
                <strong>Actividades realizadas:</strong><br>
                {{ $certificate->description }}
            </div>
        @endif

        <div class="content">
            Otorgado el {{ $certificate->issue_date->format('d \d\e F \d\e Y') }}
        </div>

        <div class="signature">
            Director de Voluntariado<br>
            Universidad Francisco de Vitoria
        </div>

        <div class="footer">
            Este certificado es válido únicamente si se verifica a través del sistema oficial de UNIFRANZ.
        </div>
    </div>
</body>
</html>
