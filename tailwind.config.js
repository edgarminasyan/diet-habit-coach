/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                cream: { 50: '#FDFCF9', 100: '#F6F4EF', 200: '#EDE9E0' },
                sage:  { 500: '#4A7259', 600: '#3A5A46' },
                peach: { 500: '#E8956D' },
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
}
