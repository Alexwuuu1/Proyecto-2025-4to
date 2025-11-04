<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Certificado - UNIFRANZ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Validar Certificado</h1>
            <p class="text-gray-600 mt-2">Sistema de Voluntariado UNIFRANZ</p>
        </div>

        <form method="POST" action="{{ route('certificates.validate') }}">
            @csrf

            <div class="mb-4">
                <label for="certificate_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Número de Certificado
                </label>
                <input type="text"
                       id="certificate_number"
                       name="certificate_number"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Ej: CERT-2025-ABC12345"
                       required>
                @error('certificate_number')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Validar Certificado
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ url('/') }}" class="text-blue-500 hover:text-blue-700 text-sm">
                ← Volver al Inicio
            </a>
        </div>
    </div>
</body>
</html>
