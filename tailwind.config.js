import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                sand: '#E5D4B1',
                white: '#FFFFFF',
                graylight: '#F5F5F5',
                graydark: '#9CA3AF',
                dark: '#1F1F1F',
            },
            boxShadow: {
                soft: '8px 8px 16px #d1d1d1, -8px -8px 16px #ffffff',
                inset: 'inset 8px 8px 16px #d1d1d1, inset -8px -8px 16px #ffffff',
            },
            borderRadius: {
                xl: '1.2rem',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, typography],
};
