<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-gradient-to-r from-unifranz-orange to-orange-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest hover:from-orange-600 hover:to-orange-700 focus:from-orange-600 focus:to-orange-700 active:from-orange-700 active:to-orange-800 focus:outline-none focus:ring-2 focus:ring-unifranz-orange focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl']) }}>
    {{ $slot }}
</button>
