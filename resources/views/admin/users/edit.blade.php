<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Editar Usuario: :name', ['name' => $user->name]) }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input id="name" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="text" name="name" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Correo Electrónico')" />
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="email" name="email" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <x-input-label for="role" :value="__('Rol')" />
                        <select id="role" name="role" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                            <option value="estudiante" {{ old('role', $user->role) === 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                            <option value="voluntario" {{ old('role', $user->role) === 'voluntario' ? 'selected' : '' }}>Voluntario</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <x-input-label for="phone" :value="__('Teléfono (Opcional)')" />
                        <x-text-input id="phone" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="text" name="phone" :value="old('phone', $user->phone)" autocomplete="tel" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Bio -->
                    <div class="mb-4">
                        <x-input-label for="bio" :value="__('Biografía (Opcional)')" />
                        <textarea id="bio" name="bio" rows="3" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" autocomplete="off">{{ old('bio', $user->bio) }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                    </div>

                    <!-- Points -->
                    <div class="mb-4">
                        <x-input-label for="points" :value="__('Puntos')" />
                        <x-text-input id="points" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="number" name="points" :value="old('points', $user->points ?? 0)" required min="0" />
                        <x-input-error :messages="$errors->get('points')" class="mt-2" />
                    </div>

                    <!-- Profile Photo -->
                    <div class="mb-6">
                        <x-input-label for="profile_photo" :value="__('Foto de Perfil (Opcional)')" />
                        <div class="mt-2 flex items-center space-x-4">
                            @if($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Current Profile Photo" class="h-16 w-16 rounded-full object-cover">
                            @else
                                <div class="h-16 w-16 rounded-full bg-gray-600 flex items-center justify-center">
                                    <span class="text-white font-medium">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <input id="profile_photo" name="profile_photo" type="file" class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-600 file:text-white hover:file:bg-orange-700" accept="image/*">
                        </div>
                        <p class="mt-1 text-sm text-gray-400">PNG, JPG, GIF up to 2MB. Deja vacío para mantener la foto actual.</p>
                        <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.users') }}" class="mr-4 text-gray-300 hover:text-white">Cancelar</a>
                        <x-primary-button class="bg-orange-500 hover:bg-orange-600">
                            {{ __('Actualizar Usuario') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
