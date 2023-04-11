/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./index.html",
      "./src/**/*.{vue,js,ts,jsx,tsx}",
    ],
    theme: {
    container: {
        center: true,
        padding: {
            DEFAULT: '.625rem',
            lg: '1rem',
        },
    },
      extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
  }
