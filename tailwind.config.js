module.exports = {
    darkMode: "class",
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
    theme: {
      extend: {
        colors: {
            "primary": "#ec5b13",
            "background-light": "#f8f6f6",
            "background-dark": "#221610",
        },
        fontFamily: {
            "display": ["Public Sans"],
            "sans": ["Public Sans", "sans-serif"]
        },
      },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/container-queries')
    ],
  }
