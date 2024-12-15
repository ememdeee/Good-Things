/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        'hanken': ['Hanken Grotesk', 'sans-serif'],
      },
    },
  },
  plugins: [],
}