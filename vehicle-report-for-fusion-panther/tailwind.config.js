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
    screens: {
      'sm': '640px',
      'md': '800px',  // Changed from the default 768px to 800px
      'lg': '1024px',
      'xl': '1280px',
      '2xl': '1536px',
    }
  },
  plugins: [],
}