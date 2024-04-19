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
            /*Creamos colores y alturas personalizadas*/
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            height:{
                "10v":"10vh",
                "15v":"15vh",
                "65v":"65vh",
            },
            colors:{
                "header":"#122235",
                "nav":"#209BD8",
                "main":"#F7F7DC",
                "footer":"#145A84"
            }

        },
    },
    /*Añadimos el plugin de daisyui*/
    plugins: [forms, require("daisyui")],
};
