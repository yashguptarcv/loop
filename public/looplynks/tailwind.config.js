/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{html,js}",
  ],
  theme: {
    extend: {
      colors: {
        primary: "#024A3F",
        secondary: "#FFB90C",
      },
      // fontFamily: {
      //   lato: ["Lato", "sans-serif"],
      //   vegawanty: ["Vegawanty", "cursive"],
      //   thunder: ["Thunder", "sans-serif"],
      // },
    },
  },
  plugins: [],
}
