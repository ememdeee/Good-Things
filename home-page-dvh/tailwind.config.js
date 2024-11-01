/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.html",  // This will include all HTML files in the root directory
    "./src/**/*.{js,ts,jsx,tsx}", // Include any JavaScript files if you have them
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}