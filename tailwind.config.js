/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,scss}", "./**/*.html"],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Titillium Web", "Roboto", "sans-serif"],
      },
    },
  },
  plugins: [],
};
