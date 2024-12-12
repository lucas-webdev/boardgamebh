/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,scss}", "./**/*.html"],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Nunito Sans", "Roboto", "sans-serif"],
      },
    },
  },
  plugins: [],
};
