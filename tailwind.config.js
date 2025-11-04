import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'volunteer-teal': '#0d9488',
                'volunteer-blue': '#2563eb',
                'volunteer-gray': '#f8fafc',
                'volunteer-gray-dark': '#e2e8f0',
                'volunteer-text': '#1e293b',
                'unifranz-gray': '#f8fafc',
                'unifranz-black': '#000000',
                'unifranz-gray-dark': '#e2e8f0',
                'unifranz-gray-text': '#64748b',
                'unifranz-orange': '#f97316',
                'unifranz-orange-light': '#fed7aa',
                'unifranz-orange-dark': '#ea580c',
                'unifranz-blue': '#1e40af',
                'unifranz-blue-light': '#dbeafe',
                'unifranz-green': '#16a34a',
                'unifranz-green-light': '#dcfce7',
                'unifranz-purple': '#7c3aed',
                'unifranz-purple-light': '#ede9fe',
            },
        },
    },

    plugins: [forms],
};
