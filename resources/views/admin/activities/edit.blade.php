<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Editar Actividad: :title', ['title' => $activity->title]) }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.activities.update', $activity) }}" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Título')" />
                        <x-text-input id="title" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="text" name="title" :value="old('title', $activity->title)" required />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Descripción')" />
                        <textarea id="description" name="description" rows="4" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" required>{{ old('description', $activity->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('Ubicación')" />
                        <x-text-input id="location" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="text" name="location" :value="old('location', $activity->location)" required />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <!-- Start Date -->
                    <div class="mb-4">
                        <x-input-label for="start_date" :value="__('Fecha de Inicio')" />
                        <x-text-input id="start_date" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="datetime-local" name="start_date" :value="old('start_date', $activity->start_date->format('Y-m-d\TH:i'))" required />
                        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                    </div>

                    <!-- End Date -->
                    <div class="mb-4">
                        <x-input-label for="end_date" :value="__('Fecha de Fin')" />
                        <x-text-input id="end_date" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="datetime-local" name="end_date" :value="old('end_date', $activity->end_date->format('Y-m-d\TH:i'))" required />
                        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                    </div>

                    <!-- Max Participants -->
                    <div class="mb-4">
                        <x-input-label for="max_participants" :value="__('Máximo de Participantes')" />
                        <x-text-input id="max_participants" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="number" name="max_participants" :value="old('max_participants', $activity->max_participants)" required min="1" />
                        <x-input-error :messages="$errors->get('max_participants')" class="mt-2" />
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <x-input-label for="status" :value="__('Estado')" />
                        <select id="status" name="status" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                            <option value="active" {{ old('status', $activity->status) === 'active' ? 'selected' : '' }}>Activa</option>
                            <option value="inactive" {{ old('status', $activity->status) === 'inactive' ? 'selected' : '' }}>Inactiva</option>
                            <option value="pending" {{ old('status', $activity->status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="completed" {{ old('status', $activity->status) === 'completed' ? 'selected' : '' }}>Completada</option>
                            <option value="cancelled" {{ old('status', $activity->status) === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.activities') }}" class="mr-4 text-gray-300 hover:text-white">Cancelar</a>
                        <x-primary-button class="bg-orange-500 hover:bg-orange-600">
                            {{ __('Actualizar Actividad') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
