<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-volunteer-text mb-2">Iniciar Sesión</h2>
        <p class="text-volunteer-text">Accede a tu cuenta de voluntariado</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-volunteer-teal focus:ring-volunteer-teal transition-colors duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-volunteer-teal focus:ring-volunteer-teal transition-colors duration-200"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-volunteer-teal shadow-sm focus:ring-volunteer-teal" name="remember">
                <span class="ms-2 text-sm text-unifranz-gray-text">{{ __('Recordarme') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-volunteer-teal hover:text-volunteer-blue font-medium transition-colors duration-200" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <div class="flex flex-col space-y-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>

            <div class="text-center">
                <p class="text-sm text-unifranz-gray-text">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-volunteer-teal hover:text-volunteer-blue font-medium transition-colors duration-200">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </form>
</x-guest-layout>
