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
            // colors: {
            //     'polri-navy': '#071D49',
            //     'polri-red': '#C8102E',
            //     'polri-silver': '#BFC3C8',
            //     'polri-silver-light': '#D9D9D9',
            //     'polri-silver-dark': '#A8ADB4',
            //     'polri-gray': '#E5E7EB',
            // },
            colors: {
                'polri-navy': '#111827',
                'polri-dark': '#1F2937',
                'polri-dark-light': '#374151',

                'polri-red': '#C8102E',

                'polri-silver': '#BFC3C8',
                'polri-silver-light': '#D9D9D9',
                'polri-silver-dark': '#A8ADB4',

                'polri-gray': '#E5E7EB',
            }
        },
    },

    plugins: [forms],
};