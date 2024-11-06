module.exports = {
  content: [
    "./*.html",  // scans HTML files in the root directory
    "./src/**/*.{html,js}",  // scans all HTML and JS files in the src directory and its subdirectories
    "./components/**/*.{html,js}"  // scans all HTML and JS files in the components directory and its subdirectories (if you have one)
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Poppins', 'sans-serif'],
      },
      fontWeight: {
        normal: 400,
        semibold: 600,
        bold: 700,
      },
    },
  },
  plugins: [],
}