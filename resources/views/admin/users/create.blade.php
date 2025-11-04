<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Crear Nuevo Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" class="p-6">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nombre')" />
                        <x-text-input id="name" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Correo Electrónico')" />
                        <x-text-input id="email" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Contraseña')" />
                        <x-text-input id="password" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <x-input-label for="role" :value="__('Rol')" />
                        <select id="role" name="role" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                            <option value="estudiante" {{ old('role') === 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                            <option value="voluntario" {{ old('role') === 'voluntario' ? 'selected' : '' }}>Voluntario</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <x-input-label for="phone" :value="__('Teléfono (Opcional)')" />
                        <x-text-input id="phone" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Bio -->
                    <div class="mb-4">
                        <x-input-label for="bio" :value="__('Biografía (Opcional)')" />
                        <textarea id="bio" name="bio" rows="3" class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" autocomplete="off">{{ old('bio') }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                    </div>

                    <!-- Profile Photo -->
                    <div class="mb-6">
                        <x-input-label for="profile_photo" :value="__('Foto de Perfil (Opcional)')" />
                        <input id="profile_photo" name="profile_photo" type="file" class="block mt-1 w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-600 file:text-white hover:file:bg-orange-700" accept="image/*">
                        <p class="mt-1 text-sm text-gray-400">PNG, JPG, GIF up to 2MB</p>
                        <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.users') }}" class="mr-4 text-gray-300 hover:text-white">Cancelar</a>
                        <x-primary-button class="bg-orange-500 hover:bg-orange-600">
                            {{ __('Crear Usuario') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
