<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Validación - UNIFRANZ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-2xl w-full bg-white rounded-lg shadow-md p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Validación de Certificado</h1>
            <p class="text-gray-600 mt-2">Sistema de Voluntariado UNIFRANZ</p>
        </div>

        @if($certificate)
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                <div class="flex items-center mb-4">
                    <svg class="w-8 h-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-green-800">Certificado Válido</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                    <div>
                        <strong>Número de Certificado:</strong><br>
                        {{ $certificate->certificate_number }}
                    </div>
                    <div>
                        <strong>Usuario:</strong><br>
                        {{ $certificate->user->name }}
                    </div>
                    <div>
                        <strong>Horas Totales:</strong><br>
                        {{ $certificate->total_hours }} horas
                    </div>
                    <div>
                        <strong>Fecha de Emisión:</strong><br>
                        {{ $certificate->issue_date->format('d/m/Y') }}
                    </div>
                    <div>
                        <strong>Estado:</strong><br>
                        <span class="px-2 py-1 rounded text-xs font-medium
                            @if($certificate->status === 'active') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($certificate->status) }}
                        </span>
                    </div>
                    @if($certificate->description)
                        <div class="md:col-span-2">
                            <strong>Descripción:</strong><br>
                            {{ $certificate->description }}
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                <div class="flex items-center mb-4">
                    <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h2 class="text-xl font-semibold text-red-800">Certificado No Encontrado</h2>
                </div>
                <p class="text-red-700">{{ $message ?? 'El número de certificado proporcionado no existe en nuestro sistema.' }}</p>
            </div>
        @endif

        <div class="text-center">
            <a href="{{ route('certificates.validate-form') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-4">
                Validar Otro Certificado
            </a>
            <a href="{{ url('/') }}" class="text-blue-500 hover:text-blue-700">
                Volver al Inicio
            </a>
        </div>
    </div>
</body>
</html>
