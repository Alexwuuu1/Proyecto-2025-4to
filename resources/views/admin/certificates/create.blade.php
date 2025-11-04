<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Crear Nuevo Certificado') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.certificates.store') }}" class="p-6">
                    @csrf

                    <!-- User -->
                    <div class="mb-4">
                        <x-input-label for="user_id" :value="__('Voluntario')" />
                        <select id="user_id" name="user_id" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                            <option value="">Seleccionar voluntario...</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                    </div>

                    <!-- Activity Title -->
                    <div class="mb-4">
                        <x-input-label for="activity_title" :value="__('Título de la Actividad')" />
                        <x-text-input id="activity_title" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="text" name="activity_title" :value="old('activity_title')" required />
                        <x-input-error :messages="$errors->get('activity_title')" class="mt-2" />
                    </div>

                    <!-- Hours Volunteered -->
                    <div class="mb-4">
                        <x-input-label for="hours_volunteered" :value="__('Horas Voluntariadas')" />
                        <x-text-input id="hours_volunteered" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="number" name="hours_volunteered" :value="old('hours_volunteered')" required min="1" step="0.5" />
                        <x-input-error :messages="$errors->get('hours_volunteered')" class="mt-2" />
                    </div>

                    <!-- Issued Date -->
                    <div class="mb-6">
                        <x-input-label for="issued_date" :value="__('Fecha de Emisión')" />
                        <x-text-input id="issued_date" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="date" name="issued_date" :value="old('issued_date', date('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('issued_date')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.certificates') }}" class="mr-4 text-gray-300 hover:text-white">Cancelar</a>
                        <x-primary-button class="bg-orange-500 hover:bg-orange-600">
                            {{ __('Crear Certificado') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
