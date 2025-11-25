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
                // Cores da identidade Imunify
                'imunify-cyan': '#3ebddb',
                'imunify-green': '#77ca73',
                'primary': {
                    50: '#e8f8fc',
                    100: '#c7eef7',
                    200: '#a2e3f2',
                    300: '#7dd8ed',
                    400: '#5fcee7',
                    500: '#3ebddb', // Cor principal cyan
                    600: '#35a7c5',
                    700: '#2b8fad',
                    800: '#227895',
                    900: '#1a5f7a',
                },
                'secondary': {
                    50: '#edf9ec',
                    100: '#d4f1d1',
                    200: '#b9e8b5',
                    300: '#9ddf98',
                    400: '#87d782',
                    500: '#77ca73', // Cor secundária green
                    600: '#66b562',
                    700: '#54a050',
                    800: '#438b3f',
                    900: '#327028',
                },
            },
        },
    },

    plugins: [forms],
};
